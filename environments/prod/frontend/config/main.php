<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
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
            'class' => 'pheme\settings\components\Settings'
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
            'languages' => ['ru', 'uk', 'en'],
            'enableLanguageDetection' => false,
            'enableDefaultLanguageUrlCode' => false,
            'enableLanguagePersistence' => true,
            // ]
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET products-category/view/<slug>'  => 'products-category/view',
                'GET products/view/<slug>'  => 'products/view',
                'news/index'       => 'news/index',
                'news/view/<slug>' => 'news/view',
                'GET news/<slug>'  => 'news/view',
                'page/view/<slug>' => 'page/view',
                'GET page/<slug>'  => 'page/view',
                'sitemap.xml'      => 'site/sitemap',
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
