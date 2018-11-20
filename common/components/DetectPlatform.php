<?php

namespace common\components;


use Yii;
use Detection\MobileDetect;


class DetectPlatform extends \yii\base\Component {

    const WEB_PLATFORM = 1;
    const MOB_PLATFORM = 2;

    private $_mobileDetect;
    private $platform;
    private $isMobile = false;
    private $isWeb = false;

    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Returns supported platforms dict with titles
     * @return array
     */
    public static function platformTitles()
    {
        return [
            self::WEB_PLATFORM => 'Web',
            self::MOB_PLATFORM => 'Mobile',
        ];
    }

    /**
     * Detect platform
     */
    public function init()
    {
        parent::init();

        // Get user agent hash for store
        $user_agent_hash = md5(Yii::$app->request->headers->get('User-Agent'));
        
        // Restore data from session
        $store_platform = Yii::$app->session->get('DetectPlatformStore');
        if (!empty($store_platform[$user_agent_hash])) {
            $this->platform = $store_platform[$user_agent_hash];

            switch ($this->platform) {
                case self::MOB_PLATFORM:
                    $this->isMobile = true;
                    break;
                default:
                    $this->isWeb = true;
                    break;
            }
            return;
        }

        // Init mobile detect lib
        $this->_mobileDetect = new MobileDetect();

        if( $this->_mobileDetect->isMobile() || $this->_mobileDetect->isTablet() )
        {
            $this->isMobile = true;
            $this->platform = self::MOB_PLATFORM;
        }
        else
        {
            $this->isWeb    = true;
            $this->platform = self::WEB_PLATFORM;
        }

        //Store platform data
        $store_platform[$user_agent_hash] = $this->platform;
        Yii::$app->session->set('DetectPlatformStore', $store_platform);
    }

    /**
     * Get platform id
     *
     *    1 - WEB
     *    2 - MOB
     *
     * @return int
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Is mobile or tablet?
     *
     * @return bool
     */
    public function isMobile()
    {
        return $this->isMobile;
    }

    /**
     * Is web?
     *
     * @return bool
     */
    public function isWeb()
    {
        return $this->isWeb;
    }

    /**
     * @return int
     */
    public function getPlatformType()
    {
        if ($this->isMobile()) {
            return self::MOB_PLATFORM;
        } else {
            return self::WEB_PLATFORM;
        }           
    }

    /**Получить массив ид платформ которые являются смежными
     * @param $platform
     * @return array
     * @throws \Exception
     */
    public static function getPlatformIDs($platform)
    {
        switch ($platform) {
            case self::MOB_PLATFORM:
                return [self::MOB_PLATFORM];
                break;

            case self::WEB_PLATFORM:
                return [self::WEB_PLATFORM];
                break;

            default:
                throw new \Exception('Undefined platform');
        }

    }

    /**
     * @param $platform1 integer
     * @param $platform2 integer
     * @return bool
     */
    public static function comparePlatforms($platform1, $platform2)
    {
        if (self::getPlatformIDs($platform1) === self::getPlatformIDs($platform2)) {
            return true;
        }
        return false;
    }
}
