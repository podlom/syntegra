<?php

namespace common\components;

use Yii;
use common\models\UserSocial;
use common\models\User;
use common\models\Bonus;
use yii\base\DynamicModel;
use frontend\models\UserToken;
use common\models\BirthdayGift;

/**
 * @property \common\models\User $_user The User model
 */
class SocialLogin extends \yii\base\Component {

    const TOKEN_NAME = 'access_token';

    static $socialNames = [
        'facebook',
        'google',
        'linkedin',
        'mailru',
        'odnoklassniki',
        'twitter',
        'vkontakte',
        'yandex',
    ];

    public $serviceUrl;
    private $access_token;
    private $_user_data;
    private $_user;
    private $_insert;
    private $_protocol = 'http://';

    public function init()
    {
        parent::init();

        $this->setAccessToken();

        //Set protocol
        $this->_protocol = (Yii::$app->request->getIsSecureConnection() ? 'https' : 'http') . '://';
    }

    /**
     * Get service URL with protocol
     * @return string
     */
    private function getServiceUrl()
    {
        return $this->_protocol . $this->serviceUrl;
    }

    /**
     * Set access token from _POST array
     * @return bool
     */
    private function setAccessToken()
    {
        $_post = Yii::$app->request->post();
        if(!empty($_post[self::TOKEN_NAME]))
        {
            $this->access_token = $_post[self::TOKEN_NAME];
            return true;
        }

        return false;
    }

    /**
     * Get user data from slogin server
     *
     * Data array (
     * [uid] => Social Id
     * [given_name]
     * [family_name]
     * [gender]
     * [birthday]
     * [city]
     * [country]
     * [email]
     * [phone]
     * [email_confirm]/ => 0 / 1
     * [phone_confirm] => 0 / 1
     * [network] - Social network name
     * [profile] - profile link
     * )
     *
     * @return bool
     */
    private function getUserData()
    {
        $host = Yii::$app->request->getServerName();

        $ch = curl_init($this->getServiceUrl() . "/token.php?token={$this->access_token}&host={$host}");
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            Yii::error('Social login: <![CDATA[errorCode:' . curl_errno($ch) . '; errorMessage:' . curl_error($ch) . ']]>', __METHOD__);
        }

        if(empty($result))
            return false;

        $data = json_decode($result,true);

        //Two required fields uid & network
        if(!is_array($data) || empty($data['uid']) || empty($data['network']))
            return false;

        $this->_user_data = $data;

        return true;
    }

    /**
     * Update user fields from social network
     */
    private function updateUserFields()
    {
        //Check email
        if( DynamicModel::validateData( ['email'=>$this->_user_data['email']],User::getEmailRule())->hasErrors() ) {
            $this->_user_data['email'] = null;
        }

        if(!empty($this->_user_data['email'])) {
            $this->_user->setEmail($this->_user_data['email']);
        }

        //Check phone
        if(DynamicModel::validateData(['phone'=>$this->_user_data['phone']], User::getPhoneRule($this->_user))->hasErrors()){
            $this->_user_data['phone'] = null;
        }

        if (!empty($this->_user_data['phone']) && !User::findOne(['phone_canonical' => User::getCanonicalPhone($this->_user_data['phone'])])) {
            $this->_user->setPhone($this->_user_data['phone']);
        }

        //Check birthday
        if(!empty($this->_user_data['birthday']))
            $this->_user->birthday = $this->_user_data['birthday'];

        //Check city
        if(!empty($this->_user_data['city']))
            $this->_user->city = $this->_user_data['city'];

        //Check country
        if(!empty($this->_user_data['country']))
            $this->_user->country = $this->_user_data['country'];

        //Check gender
        if (!empty($this->_user_data['gender']))
            $this->_user->gender = self::getGenderBySocial($this->_user_data['gender']);

        //Set username when signUP
        if( $this->_insert || empty($this->_user->username)) {
            $username = User::generateUserName();
            if( !empty($this->_user_data['email']) ) {
                $username = $this->_user_data['email'];
            }

            //Generate only unique username
            while(User::findOne(['username'=>$username])) {
                $username = User::generateUserName();
            }

            $this->_user->setUsername($username);
        }

        $this->_user->save();
    }

    public static function getGenderBySocial($socGender)
    {
        switch ($socGender) {

            case 'male':
                $gender = User::GENDER_MALE;
                break;

            case 'female':
                $gender = User::GENDER_FEMALE;
                break;

            default:
                $gender = null;
        }

        return $gender;
    }

    /**
     * Get javascript URL
     * @return string
     */
    public function getJsUrl()
    {
        return $this->getServiceUrl() . '/slogin.js';
    }

    public function login()
    {
        if(!$this->getUserData())
        {
            //Can't get data
            return false;
        }

        $this->_user = UserSocial::getUserByUidAndNetwork($this->_user_data);

        if( is_null($this->_user) )
        {
            if(Yii::$app->geoFilter->isMultiAccount()) {
                Yii::error('Ban by IP <![CDATA[Social ban]]>','BanFilter');
                Yii::$app->session->set('message', Yii::$app->geoFilter->getMultiAccountMessage());
                return false;
            }

            // Ищем юзера с таким же email как и с соц. сети
            $user = User::findOne(['email' => $this->_user_data['email']]);

            if (is_null($user)) {
                //Register
                $this->_user = new User();

                $this->_user->setIp(Yii::$app->request->getUserIP());
                //Set platform
                $this->_user->platform = Yii::$app->detectplatform->getPlatform();

                if ($this->_user->save()) {
                    $this->saveSocialUser();
                    $this->_insert = true;
                }

            } else {
                //Login native user
                $this->_user = $user;
                $this->saveSocialUser();
            }
        }

        //Update some fields from social network
        $this->updateUserFields();

        // send mail & start event onUserRegistered
        if ($this->_insert) {
            //Generate autologin. Function return autologin hash
            (new UserToken)->generate(UserToken::ACTION_AUTOLOGIN, $this->_user->id);

            if (!empty($this->_user->email)) {
                User::sendSignUpSocialMail($this->_user);
            }

            Yii::$app->eventsManager->onUserRegistered($this->_user);

            Yii::$app->trackcode->saveSignUp($this->_user->id);

            //TrackingPixel show
            Yii::$app->trackingPixel->addAction('signUp', $this->_user->id);


            //add welcome bonus
            if (isset($_COOKIE['welcome_bonus_id'])) {
                //фіксіємо welcome-бонус
                Bonus::setWelcomeBonus($this->_user->id, $_COOKIE['welcome_bonus_id']);
                //видаляємо куку для надання бонуса через соц. реєстранцію.
                //щоб більше не викликалось надання бонуса
                setcookie('welcome_bonus_id', false, time() - 1);
            }
        }

        if ($this->_user->blocked) {

            Yii::$app->session->set('message', $this->_user->getBlockedMessage());

            return false;
        }

        BirthdayGift::checkAndAddBirthdayGift($this->_user);

        return Yii::$app->user->login($this->_user, Yii::$app->params['login_cookie_life_time']);
    }


    protected function saveSocialUser()
    {
        //Save User social
        $UserSocial = new UserSocial();
        $UserSocial->user_id = $this->_user->id;
        $UserSocial->uid     = $this->_user_data['uid'];
        $UserSocial->service = $this->_user_data['network'];
        $UserSocial->data    = json_encode($this->_user_data);
        $UserSocial->save();
    }
}