<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'loginUrl' => '/user/login',
            'identityCookie' => [ // <---- here!
                'name' => 'uuid2',
                'httpOnly' => true,
                'domain' => '.hkej.com',
            ],
        ],        
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'ADCVWEDHJK',
        ],
        'session' => [
            'cookieParams' => [
                'domain' => '.hkej.com',
                'httpOnly' => true,
            ],
            'timeout' => 43200,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
             'maxSourceLines' => 20,
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

        //'db' => require(__DIR__ . '/db.php'),
        'db' => require(__DIR__ . '/dbAurora.php'),
        'dbauroralj' => require(__DIR__ . '/dbAuroralj.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */

        'urlManager' => [  
            'class' => 'yii\web\UrlManager',        
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                //  use temporary redirection instead of permanent for debugging
                //'collapseSlashes' => true,
                //'normalizeTrailingSlash' => false,
            ],
            'rules'=>[
                //'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'lj2017' => 'lj',
                'lj2017/<action:\w+>' => 'lj/<action>',
                'lj2017/fashion/' => 'lj/fashion/',
                
            ],
        ],
    
    ],
    'params' => $params,
    'defaultRoute'=>'lj/index',
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
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
