<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
    require(__DIR__ . '/../../common/config/lang.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru',
        'sourceLanguage' => 'en',
    'components' => [
        'settings' => [
            'class' => 'pheme\settings\components\Settings',
            'cache' => 'pheme-settings-sy-cache',
            'frontCache' => 'pheme-settings-sy-front-cache',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],

        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => [
                // uncomment this to use streams in safe_mode
                //'useStreamsFallback' => true,
            ],
            'services' => [ // You can change the providers and their classes.
                'google' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'nodge\eauth\services\GoogleOAuth2Service',
                    'clientId' => '998098951231-f1p73b40l48t30pnhnl23rqgttja47ku.apps.googleusercontent.com',
                    'clientSecret' => 'RjIHqo88LY2BMfGr-mAYSTcY',
                    'title' => 'Google',
                ],
                'twitter' => [
                    // register your app here: https://dev.twitter.com/apps/new
                    'class' => 'nodge\eauth\services\TwitterOAuth1Service',
                    'key' => 'jdPCoPJfBkIuhgPpPYMjAZm59',
                    'secret' => 'bLG39BeIMA6n0dJZwoyY2P29DkqmhltXOrrdb0Toc0rqB1YIAj',
                ],
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    //'authUrl'=>'https://www.facebook.com/dialog/oauth?display=popup',
                    'clientId' => '501365433542802',
                    'clientSecret' => '977c5e3cdac7fa9ed109d95e7f61eadc',
                ],
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'view' => [
            'class' => '\smilemd\htmlcompress\View',
            'compress' => YII_ENV_DEV ? false : true,
        ],
        'urlManager' => [
            // [ @see: https://github.com/codemix/yii2-localeurls
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => array_keys($params['languages']),
            'enableLanguageDetection' => false,
            'enableDefaultLanguageUrlCode' => false,
            'enableLanguagePersistence' => true,
            // ]
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

               'GET form/<id>' => 'form/view',
                'GET partner/<slug>' => 'partner/index',
                'case-studies/' => 'partner-category/index',

                'GET products-category/view/<slug>'  => 'products-category/view',
                'products-category/<slug>'  => 'products-category/view',
                'GET products/view/<slug>'  => 'products/view',
                //
                'GET images/product/<img_url>'  => 'products/view-img',
                //

                'GET blog'       => 'news/index',
                // 'news/view/<slug>' => 'news/view',
                'GET blog/<slug>'  => 'news/view',
                //
                'GET sitemap.xml'      => 'site/sitemap',
                // 'page/view/<slug>' => 'page/view',
                // 'GET page/<slug>'  => 'page/view',
                'GET page/<slug>'  => 'page/view',

                'GET <slug>'  => 'page/index',


            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'app' => 'app.php',
                        //'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
