<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

Yii::setAlias('@frontendBaseUrl', 'http://syntegra.local/');

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'settings' => [
            'class' => 'pheme\settings\Module',
            'sourceLanguage' => 'en'
        ],
        'utility' => [
            'class' => 'c006\utility\migration\Module',
        ],
    ],
    'components' => [
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\User', // 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            // 'baseUrl' => @frontend,
            'baseUrl' => '@frontendBaseUrl',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'i18n' => [
            'translations' => [
                'extensions/yii2-settings/settings' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/pheme/yii2-settings/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'extensions/yii2-settings/settings' => 'settings.php',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
