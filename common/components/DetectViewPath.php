<?php

namespace common\components;

use Yii;
use yii\base\Component;

class DetectViewPath extends Component
{

    /**
     * Set template name^ will be different for each project
     * @var templateName
     */
    public $templateName;

    //Outter url or CDN URL
    public $baseUrl = '';

    public $cdnSubdomains = [];

    //Static folder name
    public $staticFolderName = 'static';

    //Assets folder name
    public $assetsFolderName = 'assets';

    //Add static version
    public $staticVersion = false;

    //Static version name
    public $staticVersionName = 'img-v';


    private function buildFolderPath()
    {
        $platform = Yii::$app->detectplatform->isMobile() ? 'mob' : 'web';
        return DIRECTORY_SEPARATOR . $this->templateName . DIRECTORY_SEPARATOR . $platform;
    }

    /**
     * Change view path use template name and platform
     */
    public function init()
    {
        parent::init();

        //Set default value
        if(empty($this->baseUrl)) {
            $this->baseUrl = Yii::getAlias('@web');
        }

        $version = '';
        if($this->staticVersion && !empty($this->staticVersionName)) {
            $version .= DIRECTORY_SEPARATOR . $this->staticVersionName . $this->staticVersion;
        }

        Yii::$app->setViewPath( Yii::$app->getViewPath() . $this->buildFolderPath() );
        Yii::setAlias('static', $this->baseUrl . DIRECTORY_SEPARATOR . $this->staticFolderName . $version . $this->buildFolderPath());
        Yii::setAlias('staticroot', Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $this->staticFolderName . $this->buildFolderPath());

        Yii::setAlias('assets', $this->baseUrl . DIRECTORY_SEPARATOR . $this->assetsFolderName);
    }
}