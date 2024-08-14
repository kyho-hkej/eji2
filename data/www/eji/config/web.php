<?php

$params = require __DIR__ . '/params.php';
//$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'HKEJ',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        //'@MobileDetect' =>  '@vendor/MobileDetect',
    ],
    'components' => [
        'db' => require(__DIR__ . '/dbAurora_ro.php'),
        'dbaurora' => require(__DIR__ . '/dbAurora.php'), 
        'dbMainsiteRemoteWeb' => require(__DIR__ . '/nejdb1.php'),
        //'db' => require (__DIR__ . '/db.php'),
        //'dbaurora' => (require __DIR__ . '/db.php'),
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ZXCVWEDHJK',
        ],
        'fileCache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'urlManager' => [  
            'class' => 'yii\web\UrlManager',        
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules'=>[
                'eji' => 'eji/index',
                //'ejiv2' => 'ejiv2/index',
                //'<w+>' => '<controller>/<action>',
                //http://dev-eji.hkej.com/eji/category/business/page/2
                //'<controller:\w+>/<action:\w+>/<category:\w+>/page/<page:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<category:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //http://dev-eji.hkej.com/eji/article/id/2400057
                '<controller:\w+>/<action:\w+>/id/<id:\d+>' => '<controller>/<action>',
                //http://dev-eji.hkej.com/eji/article/id/2400057/20200311-Mandatory-quarantine-to-cover-several-regions-in%20Europe-Japan
                '<controller:\w+>/<action:\w+>/id/<id:\d+>/<subjectline>' => '<controller>/<action>',

            ],

            
        ],

        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
            //'class' => '\skeeks\yii2-mobile-detect\src\MobileDetect'
        ],

        'user' => [
            'identityClass' => 'app\models\HKEJUser',
            'enableAutoLogin' => false,
        ],
    ],
    'params' => $params,
    'defaultRoute'=>'eji/index',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'allowedIPs' => ['192.168.250.5', '::1'],
    ];
}

return $config;
