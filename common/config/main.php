<?php
$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru',
    'components' => [
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'detectplatform' => [
            'class' => 'common\components\DetectPlatform',
        ],
        'log' => [
            'traceLevel' => 3,
            'flushInterval' => 1,
            'targets' => [
                'db' => [
                    'class' => 'common\components\ErrorLog',
                    'levels' => ['error', 'warning'],
                    'exportInterval' => 1,
                ],

            ],
        ],
        /*
        'trackingPixel' => [
            'class' => 'common\components\TrackingPixel',
        ],
        */
    ],
];

if( defined('YII_ENV_PROD') && YII_ENV_PROD ) {
    $config['components']['log']['targets']['email'] = [
        'class' => 'yii\log\EmailTarget',
        'levels' => ['error'],
        'categories' => ['yii\db\*'],
        'message' => [
            'from' => ['errors@syntegra.com.ua'],
            'to' => ['T.Shkodenko@wdss.com.ua'],
            'subject' => 'Database errors on website ' . $_SERVER['HTTP_HOST'],
        ],
        'exportInterval' => 1,
    ];
} else {
    $config['components']['log']['targets']['file'] = [
        'class' => 'yii\log\FileTarget',
        'levels' => ['error'],
        'categories' => ['yii\db\*'],
        'exportInterval' => 1,
    ];
}

return $config;