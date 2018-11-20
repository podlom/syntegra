<?php

namespace common\components;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * @inheritdoc
 *
 * Class Mail
 * @package common\components
 */
class Mail extends \yii\base\Component
{
    const TEMPLATE_SIGNUP  = 'signup';
    const TEMPLATE_SIGNUP_SOCIAL  = 'signup_social';
    const TEMPLATE_SIGNUP_WITH_PASSWORD  = 'signup_with_password';
    const TEMPLATE_CONFIRM = 'confirm';
    const TEMPLATE_CHANGE_PASSWORD  = 'change_password';

    const TEMPLATE_SUCCESSFUL_PAYOUT = 'successful_payout';

    //WELCOME BONUSES TEMPLATES
    const TEMPLATE_WB_X2 = 'active_deal_reminder_vstupitelnuibonus2xb';
    const TEMPLATE_WB_POINTS = 'active_deal_reminder_vstupitelnuibonus50b';
    const TEMPLATE_WB_SPINS = 'active_deal_reminder_vstupitelnuibonus10spins';

    //ACTIVE SALES
    const TEMPLATE_AS_10_PERCENT_OF_DEP = 'active_deal_reminder_10percentsofdep';

    const TEMPLATE_CASHBACK_PAYOUT = 'cashback_clone_var2';
    const TEMPLATE_WIN_RATING_TOP_ONE = 'win_rating_top_one';

    //Birthday gifts
    const TEMPLATE_BG_FREE = '20160301_happy_birthday_free';
    const TEMPLATE_BG_SMALL = '20160301_happy_birthday_smallpaids';
    const TEMPLATE_BG_VIP = '20160301_happy_birthday_vip';

    const CONSUMER_KEY = 'SEND2CRM';
    const EXCHANGE     = 'SEND2CRM';
    const QUEUE_NAME   = 'SEND2CRM';

    public $crmHost;
    public $crmSecret;
    public $crmProjectId;
    private $crmResponse;

    /**
     * Send data to CRM
     * @param $data
     * @return mixed
     */
    private function sendToCRM($data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->crmHost);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $this->crmResponse = curl_exec($curl);

        if (curl_errno($curl)) {
            Yii::error('Send to CRM: <![CDATA[errorCode:' . curl_errno($curl) . '; errorMessage:' . curl_error($curl) . ']]>', __METHOD__);
        }

        curl_close($curl);

        return json_decode($this->crmResponse);
    }

    /**
     * Mail send function
     * @param User $user
     * @param $template
     * @param $data
     * @param $system
     * @throws Exception
     */
    public function sendMail(User $user, $template, $data, $system = false)
    {
        if(empty($user->email)){
            throw new Exception('email is empty!');
        }

        $data['user_id'] = $user->id;

        $data_to_send = array(
            'action' => 'send',
            'project_id' => $this->crmProjectId,
            'sign' => $this->getSignification('send'),
            'email' => $user->email,
            'template_id' => $template,
            'data' => $data,
            'system' => $system
        );

        $this->sendToQueue($data_to_send);
    }

    /**
     * Unsubscribe function
     * @param $email
     */
    public function sendUnsubscribe($email)
    {
        $data_to_send = array(
            'action' => 'unsubscribe',
            'project_id' => $this->crmProjectId,
            'sign' => $this->getSignification('unsubscribe'),
            'email' => $email,
            'level' => 1
        );

        $this->sendToQueue($data_to_send);
    }

    /**
     * Send SMS message
     * @param $phone
     * @param $data
     * @param null $sendAt
     * @throws \Exception
     */
    public function sendSMS($phone, $data, $sendAt = null)
    {
        $data_to_send = array(
            'action' => 'sendsms',
            'project_id' => $this->crmProjectId,
            'sign' => $this->getSignification('sendsms'),
            'phone' => $phone,
        );

        if (!is_null($sendAt))
            $data_to_send['send_at'] = $sendAt;

        if (isset($data['template']))
        {
            $data_to_send['template_id'] = $data['template'];
            if (isset($data['data']))
                    $data_to_send['data'] = $data['data'];
            elseif (isset($data['text']))
                $data_to_send['text'] = $data['text'];
        }
        else
            throw new \Exception('No text or template found');

        $this->sendToQueue($data_to_send);
    }

    /**
     * Get hashed sign
     * @param $action
     * @return string
     */
    public function getSignification($action)
    {
        return sha1($action . $this->crmProjectId . $this->crmSecret);
    }

    private function getQueueName()
    {
        return 'ha-' . Yii::$app->params['projectSuffix'] . '-' . self::QUEUE_NAME;
    }

    /*
    * Получение списка сообщений из очереди Amqp
    */
    public function getAmqpMessageList() 
    {
        return Yii::$app->amqp->getMessagesList(self::EXCHANGE, self::getQueueName());
    }

    /**
     * Add message to queue
     * @param $data
     * @throws Exception
     */
    private function sendToQueue($data)
    {
        //Prepare message
        $data = Json::encode($data);
        try {
            Yii::$app->amqp->send(self::EXCHANGE, $this->getQueueName(), $data);
        } catch(Exception $e) {
            throw new Exception("Сообщение не добавилось в очередь {$e->getMessage()}");
        }
    }

    /**
     * Get messages from queue and parse it
     */
    public function sendFromQueue()
    {
        Yii::$app->amqp->listen(self::EXCHANGE, $this->getQueueName(), self::CONSUMER_KEY,
            function($msg){
                //Decode message
                try {

                    $result = $this->sendToCRM(Json::decode($msg->body));
                    if(is_object($result)) {
                        if($result->success) {
                            Yii::$app->amqp->deleteMessage($msg);
                        } else {
                            Yii::error("Сообщение не отправленно: <![CDATA[msg[".$result->msg."]; body=" . $msg->body.']]>', 'send2crm');
                        }
                    } else {
                        Yii::error("Сообщение не отправленно: <![CDATA[msg[".$this->crmResponse."] ]]>", 'send2crm');
                    }

                } catch(Exception $e) {
                    Yii::error("Сообщение не отправленно <![CDATA[{$e->getMessage()}]]>", 'send2crm');
                }
            }
        );
    }
}