<?php

namespace common\components;

use Yii;
use common\models\TrackCodeClick;
use common\models\TrackCode;
use common\models\TrackCodeAction;

class DetectTrackCode extends \yii\base\Component {

    const GET_PNAME = 'trackCode';
    const SKIP_GET_PNAME = 'skipTrackCode';
    const GET_PNAME_NO_REDIRECT = 'trackCodeNR';
    const COOKIE_NAME_USER_HASH = 'trackCodeUserHash';
    const SESSION_NAME = 'trackCode';
    const DEFAULT_TC = 'direct|~project~|~date~';
    //TTL in days
    const SESSION_TTL = 30;

    const ACTION_SIGNUP = 'signup';
    const ACTION_LOGIN  = 'login';

    const GET_ANCHOR = 'popupAnchor';

    private $trackCode;
    private $userHash;
    private $clickHash;
    private $time;
    private $action;

    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Detect refcode
     */
    public function init()
    {
        parent::init();

        //Пропускаем залогиненого пользователя
        if(!Yii::$app->user->getIsGuest())
        {
            return false;
        }

        //Пропускаем Ajax запросы
        if(Yii::$app->request->getIsAjax())
        {
            return false;
        }

        //Not create for redirector
        if(defined('PROXY-DETECTOR-REWRITE')) {
            return false;
        }

        //Remove tracking code for some links
        if(Yii::$app->request->get(self::SKIP_GET_PNAME)) {
            return false;
        }

        //Generate user hash
        $this->userHash = $this->getUserHash();
        $this->time = time();

        //Check get parameter
        $this->trackCode = Yii::$app->request->get(self::GET_PNAME);
        if(!empty($this->trackCode)) {

            $this->clickAction();
            $this->saveTrackCodeStore();

            return Yii::$app->response->redirect($this->getUrlToRedirect());
        }

        $rep['~project~'] = Yii::$app->params['projectSuffix'];
        $rep['~date~'] = date('Y-m-d');
        $this->trackCode = str_replace(array_keys($rep),$rep,static::DEFAULT_TC);

        if(!$this->getTrackCodeStore()) {
            if(!$this->setOldClickHash($this->userHash, TrackCode::getTrackCodeId($this->trackCode))) {
                $this->clickAction();
            }

            $this->saveTrackCodeStore();
            return true;
        }

        return false;
    }

    /**
     * Save track code in session
     */
    private function saveTrackCodeStore()
    {
        $value['time'] = $this->time;
        $value['trackCode'] = $this->trackCode;
        $value['userHash'] = $this->userHash;
        $value['clickHash'] = $this->clickHash;

        Yii::$app->session->set(self::SESSION_NAME, $value);
    }

    /**
     * Check TTL and get trackode from session
     * @return mixed|null
     */
    private function getTrackCodeStore()
    {
        $value = Yii::$app->session->get(self::SESSION_NAME);
        //If empty or TTL is end return null
        if(empty($value) || ($value['time'] + self::SESSION_TTL * 86400) < time())
        {
            return null;
        }

        return $value;
    }

    /**
     * Clear tracking code session
     */
    private function clearTrackCodeStore()
    {
        Yii::$app->session->set(self::SESSION_NAME,[]);
    }

    /**
     * Get user hash from cookie or generate
     * @return string
     */
    private function getUserHash(){
        $userHash = Yii::$app->request->cookies->get(self::COOKIE_NAME_USER_HASH);
        if(empty($userHash))
        {
            $userHash = md5( Yii::$app->request->getUserIP() . Yii::$app->request->getUserAgent() );
        }

        return $userHash;
    }

    /**
     * Get cut URL for redirect
     * @return string
     */
    private function getUrlToRedirect()
    {
        $url = '/' . Yii::$app->request->getPathInfo();
        $queryString = Yii::$app->request->getQueryString();

        if (!empty($queryString)) {
            $params = array();

            parse_str($queryString, $params);

            if (isset($params[self::GET_PNAME])) {
                unset($params[self::GET_PNAME]);
            }

            $anchor = '';
            if (isset($params[self::GET_ANCHOR]) && !empty($params[self::GET_ANCHOR])) {
                $anchor = '#' . $params[self::GET_ANCHOR];
                unset($params[self::GET_ANCHOR]);
            }

            $queryString = http_build_query($params);

            if (!empty($queryString)) {
                $url .= '?' . $queryString . $anchor;
            }

        }

        return $url;
    }

    /**
     * Save Click action for trackCode
     */
    private function clickAction()
    {
        //Set variables
        $this->clickHash = md5( $this->userHash . time() );

        $tCC = new TrackCodeClick();
        $tCC->user_hash = $this->userHash;
        $tCC->setIp(Yii::$app->request->getUserIP());
        $tCC->request_uri = Yii::$app->request->getUrl();
        $tCC->trackcode_id = TrackCode::getTrackCodeId($this->trackCode);
        $tCC->date = date('Y-m-d H:i:s', $this->time);
        $tCC->click_hash = $this->clickHash;

        $tCC->referer = '';
        if(Yii::$app->request->getReferrer())
            $tCC->referer = Yii::$app->request->getReferrer();

        $tCC->save();
    }

    /**
     * Save login and signup actions for trackCode
     * @param $user_id
     */
    private function saveAction($user_id)
    {
        $var = $this->getTrackCodeStore();
        if(is_null($var))
            return;

        $tCA = new TrackCodeAction();
        $tCA->click_hash = $var['clickHash'];
        $tCA->user_id = $user_id;
        $tCA->date = date('Y-m-d H:i:s', time());
        $tCA->action = $this->action;

        $tCA->save();
    }

    /**
     * SignUp action for trackCode
     * @param $user_id
     */
    public function saveSignUp($user_id)
    {
        $this->action = self::ACTION_SIGNUP;
        $this->saveAction($user_id);
        $this->clearTrackCodeStore();
    }

    /**
     * Login action for trackCode
     * @param $user_id
     */
    public function saveLogin($user_id)
    {
        $this->action = self::ACTION_LOGIN;
        $this->saveAction($user_id);
        $this->clearTrackCodeStore();
    }

    /**
     * Get trackCode by user_id
     * @param $user_id
     * @return string
     */
    public function getTrackCodeByUserId($user_id)
    {
        if(empty($user_id))
            return '';

        $res = (new \yii\db\Query())
            ->select('tc.value')
            ->from(TrackCodeAction::tableName() . ' AS tca')
            ->join('JOIN', TrackCodeClick::tableName() . ' AS tcc', 'tcc.click_hash = tca.click_hash')
            ->join('JOIN', TrackCode::tableName() . ' AS tc', 'tc.id = tcc.trackcode_id')
            ->where([
                'user_id' => (int)$user_id
            ])
            ->orderBy(['tca.date' => SORT_DESC])
            ->limit(1)
            ->column();

        if(empty($res))
            return '';

        return $res[0];
    }

    public static function getUserTrackCodes($user_id)
    {
        if (empty($user_id))
            return [];

        $userTrackCodes = (new \yii\db\Query())
            ->select('tc.value')
            ->from(TrackCodeAction::tableName() . ' AS tca')
            ->join('JOIN', TrackCodeClick::tableName() . ' AS tcc', 'tcc.click_hash = tca.click_hash')
            ->join('JOIN', TrackCode::tableName() . ' AS tc', 'tc.id = tcc.trackcode_id')
            ->where([
                'user_id' => (int)$user_id
            ])
            ->distinct()
            ->column();

        if (empty($userTrackCodes))
            return [];

        return $userTrackCodes;
    }

    /**
     * TODO: Need refactoring
     * Add trackCode
     * @param $ip string
     * @param $trackCode string
     * @param $user_id int
     */
    public static function externalSignUp($ip, $trackCode, $user_id) {

        //Set variables
        $time = time();
        $userHash = md5(Yii::$app->request->getUserIP() . Yii::$app->request->getUserAgent());
        $clickHash = md5( $userHash . $time );

        $tCC = new TrackCodeClick();
        $tCC->user_hash = $userHash;
        $tCC->setIp($ip);
        $tCC->request_uri = Yii::$app->request->getUrl();
        $tCC->trackcode_id = TrackCode::getTrackCodeId($trackCode);
        $tCC->date = date('Y-m-d H:i:s', $time);
        $tCC->click_hash = $clickHash;
        $tCC->referer = '';
        $tCC->save();

        $tCA = new TrackCodeAction();
        $tCA->click_hash = $clickHash;
        $tCA->user_id = $user_id;
        $tCA->date = date('Y-m-d H:i:s', $time);
        $tCA->action = static::ACTION_SIGNUP;

        $tCA->save();
    }

    /**
     * Get click hash by user hash and track code id
     * @param $userHash
     * @param $trackcode_id
     */
    private function setOldClickHash($userHash, $trackcode_id) {

        if(empty($userHash) || empty($trackcode_id))
            return false;

        $res = (new \yii\db\Query())
            ->select('tcc.click_hash as click_hash,UNIX_TIMESTAMP(tcc.date) as time')
            ->from(TrackCodeClick::tableName() . ' AS tcc')
            ->join('LEFT JOIN', TrackCodeAction::tableName() . ' AS tca', 'date(tcc.date)=date(tca.date) AND tcc.click_hash=tca.click_hash')
            ->where(['user_hash'=>$userHash, 'trackcode_id'=>$trackcode_id])
            ->orderBy(['tcc.date' => SORT_DESC])
            ->limit(1)
            ->one();

        if(empty($res))
            return false;

        $this->time = $res['time'];
        $this->clickHash = $res['click_hash'];

        return true;

    }
}