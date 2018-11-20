<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Lato:300,400,700,900',
        'assets/skin/default_skin/css/theme.css',
        'css/site.css',
    ];
    public $js = [
        // 'plugins/core.min.js',
        'assets/js/utility/utility.js',
        'assets/js/demo/demo.js',
        'assets/js/main.js',
        //'assets/js/form-builder.min.js',
        //'assets/js/form-render.min.js',
       'assets/js/jquery.rateyo.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
