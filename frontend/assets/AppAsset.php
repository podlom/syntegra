<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        '//fonts.googleapis.com/css?family=Roboto:100,100i,400,400i,500,500i,700,700i,900,900i&amp;amp;subset=cyrillic,cyrillic-ext,latin-ext',
        '/css/style.min.css',
    ];

    public $js = [
       //'js/app.min.js',
        //'js/form-render.min.js',
        //'js/form-builder.min.js',
        'js/jquery.rateyo.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\web\JqueryAsset',
    ];


    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        $manager = $view->getAssetManager();
    }
}
