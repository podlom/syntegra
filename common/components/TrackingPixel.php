<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use common\models\TrackCode;
use common\models\TrackCodeAction;
use common\models\TrackCodeClick;

/*
Example of params array
'trackingPixel' => [
                    'prefix' => ['action'  => ['trackingUrl={CLICK_ID}']],
                    'trackcode_exists' => ['action' => ['trackingUrl={CLICK_ID}']],
                    'all_users' =>  ['action' => ['trackingUrl']],
                    ],

'trackingPixelVariables' => ['CLICK_ID']
*/

class TrackingPixel extends Component
{
    const CONSUMER_KEY = 'SendTrackingPixel';

    const EXCHANGE = 'SendTrackingPixel';

    const QUEUE_NAME  = 'SendTrackingPixel';

    /**
     * The number of attempts to send TrackingPixel
     */
    const ATTEMPTS_NUMBER = 2;

    /**
     * генерация трекинг пикселей
     */
    public function show($userId)
    {
        $cacheKey = Yii::$app->params['cache.name.trackingpixel'] . $userId;

        // выход, если нет кеша
        if (!Yii::$app->cache->exists($cacheKey)) {
            return;
        }

        $result = '';
        $urls = Yii::$app->cache->get($cacheKey);
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $result .= Html::img($url, ['height' => 0, 'width' => 0, 'style' => 'position:absolute; left:-9999px;']);
            }
        }

        Yii::error("Show tracking: <![CDATA[[".print_r([ $userId, $urls ],1)."] ]]>", 'TrackingPixel');

        // удаляем кеш
        Yii::$app->cache->delete($cacheKey);
        return $result;
    }

    /**
     * @return boolean
     * установка секции
     */
    public function addAction($action, $userId)
    {
        // не заданы настройки пикселя
        if (empty(Yii::$app->params['trackingPixel']) || empty(Yii::$app->params['trackingPixelVariables'])) {
            return;
        }

        $cacheKey = Yii::$app->params['cache.name.trackingpixel'] . $userId;

        $result = [];
        // если в кеше что то есть, выбираем сначала отуда
        if (Yii::$app->cache->exists($cacheKey)) {
            $result = Yii::$app->cache->get($cacheKey);
        }

        $trackCode = $this->getTrackCodeInfo($userId);

        // список переменных на замену
        $variables = [];
        if (!empty($trackCode['request_uri'])) {

            $aUrl = parse_url($trackCode['request_uri']);
            if(!empty($aUrl['query'])) {
                parse_str($aUrl['query'], $parse_uri);

                if (count($parse_uri) > 0) {
                    foreach (Yii::$app->params['trackingPixelVariables'] as $varialbe) {
                        if (!empty($parse_uri[$varialbe])) {
                            $variables[$varialbe] = $parse_uri[$varialbe];
                        }
                    }
                }
            }
        }

        // наполняем массив урлов для кеша
        $trackingPixelUrls = Yii::$app->params['trackingPixel'];
        foreach ($trackingPixelUrls as $prefix => $actions) {
            // проверка на вхождение в массив префиксов
            if (
                ($trackCode && (strpos($trackCode['track_code'], $prefix) === 0 || $prefix == 'trackcode_exists')) || 
                $prefix == 'all_users'
               ) 
            {
                if (!empty($trackingPixelUrls[$prefix][$action])) {
                    // формируем ссылки для кеша
                    foreach ($trackingPixelUrls[$prefix][$action] as $index => $url) {
                        if ($index === 's2s') {
                            continue;
                        }
                        // заменяем переменные в урле
                        foreach ($variables as $key => $variable) {
                            $url = str_replace('{' . $key . '}', $variable, $url);
                        }
                        if (!empty($trackingPixelUrls[$prefix]['s2s']) || !empty($trackingPixelUrls[$prefix][$action]['s2s'])) {
                            $this->addToQueue($url);
                        } else {
                            $result[$url] = $url;
                        }

                    }
                }
            }
        }

        // пишем в кеш
        if (count($result) > 0) {
            if (Yii::$app->cache->exists($cacheKey)) {
                Yii::$app->cache->set($cacheKey, $result);
                return true;
            }

            Yii::$app->cache->add($cacheKey, $result);
        }

        return true;
    }

    /**
     * Get trackCode by user_id
     * @param $userId
     * @return string
     */
    protected function getTrackCodeInfo($userId)
    {
        if (empty($userId)) {
            return false;
        }

        $res = (new \yii\db\Query())
            ->select('tc.value as track_code, tcc.request_uri')
            ->from(TrackCodeAction::tableName() . ' AS tca')
            ->join('JOIN', TrackCodeClick::tableName() . ' AS tcc', 'tcc.click_hash = tca.click_hash')
            ->join('JOIN', TrackCode::tableName() . ' AS tc', 'tc.id = tcc.trackcode_id')
            ->where([
                'user_id' => (int)$userId
            ])
            ->orderBy(['tca.date' => SORT_DESC])
            ->limit(1)
            ->all();

        if (empty($res)) {
            return false;
        }

        return $res[0];
    }

    /**
     * @param $data
     */
    private function send($data)
    {
        $i = 0;
        while(!$this->sendTrackingPixel($data) && $i < self::ATTEMPTS_NUMBER) {
            sleep(1);
            $i++;
        }
    }

    /**
     * Add message to queue
     * @param $data
     * @throws \Exception
     */
    private function addToQueue($data)
    {
        try {
            Yii::$app->amqp->send(self::EXCHANGE, self::QUEUE_NAME, Json_encode($data));
        } catch(\Exception $e) {
            throw new \Exception("Данные не добавилось в очередь {$e->getMessage()}");
        }
    }


    /**
     * Get messages from queue and parse it
     */
    public function pullFromQueue()
    {
        Yii::$app->amqp->listen(self::EXCHANGE, self::QUEUE_NAME, self::CONSUMER_KEY,
            function($msg){
                $this->send(Json_decode($msg->body, true));
                Yii::$app->amqp->deleteMessage($msg);
            }
        );
    }

    /**
     * @param $url
     * @return mixed
     */
    private function sendTrackingPixel($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        $resp = curl_exec($curl);
        $hasErrors = curl_errno($curl);
        if ($hasErrors) {
            Yii::error('Send TrackingPixel: <![CDATA[errorCode:' . curl_errno($curl) . '; errorMessage:' . curl_error($curl) . ']]>', __METHOD__);
        } else {
            Yii::error('Send TrackingPixel: <![CDATA[Url:' . $url . '; Response: '.$resp.'; Errors: '.$hasErrors.']]>', __METHOD__);
        }

        curl_close($curl);

        return $hasErrors == false;
    }

    /**
    * Получение списка сообщений из очереди Amqp
    */
    public function getAmqpMessageList()
    {
        return Yii::$app->amqp->getMessagesList(self::EXCHANGE, self::QUEUE_NAME);
    }


}