<?php

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'HKEJ',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => require(__DIR__ . '/dbAurora_ro.php'),
        'dbaurora' => require(__DIR__ . '/dbAurora.php'), 
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
                    'levels' => ['error', 'warning', 'trace'],
                ],
            ], 
        ],
        
        'urlManager' => [  
            'class' => 'yii\web\UrlManager',      	
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            /*'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                //  use temporary redirection instead of permanent for debugging
                //'collapseSlashes' => true,
                //'normalizeTrailingSlash' => false,
            ],*/
            'rules'=>[
                //http://dev-ejm.hkej.com/monthly/article/id/撐粵語之兼融善變
                '<controller:\w+>/<action:\w+>/id/<id:\d+>/<subjectline>' => '<controller>/<action>',
                'monthly' => 'monthly/index',
                'landingMob' => 'landingmob/index',
                'landingMob/' => 'landingmob/index',
                'landingMob/index' => 'landingmob/index',
                'instantnewsMob' => 'instantnewsmob/index',
                'instantnewsMob/' => 'instantnewsmob/index',
                'instantnewsMob/index' => 'instantnewsmob/index',
                'landingMob/<action:\w+>' => 'landingmob/<action>',
                'instantnewsMob/<action:\w+>' => 'instantnewsmob/<action>',
                'propertyMob/<action:\w+>' => 'propertymob/<action>',
                'propertyMob' => 'propertymob/index',
                'propertyMob/' => 'propertymob/index',
                'propertyMob/index' => 'propertymob/index',
                'dailynewsMob/<action:\w+>' => 'dailynewsmob/<action>',
                'dailynewsMob' => 'dailynewsmob/index',
                'dailynewsMob/' => 'dailynewsmob/index',
                'dailynewsMob/index' => 'dailynewsmob/index',
                'hkejwriterMob/<action:\w+>' => 'hkejwritermob/<action>',
                'hkejwriterMob' => 'hkejwritermob/index',
                'hkejwriterMob/' => 'hkejwritermob/index',
                'hkejwriterMob/index' => 'hkejwritermob/index',
                'multimediaMob/<action:\w+>' => 'multimediamob/<action>',
                'multimediaMob' => 'multimediamob/index',
                'multimediaMob/' => 'multimediamob/index',
                'multimediaMob/index' => 'multimediamob/index',
                'multimediaMob/<action:\w+>' => 'multimediamob/<action>',
                'featuresMob/<action:\w+>' => 'featuresmob/<action>',
                'featuresMob' => 'featuresmob/index',
                'featuresMob/' => 'featuresmob/index',
                'featuresMob/index' => 'featuresmob/index',
                'featuresMob/Category' => 'featuresmob/category',
                'landing/mobArticle2' => 'landing/mob-article2',
                'wmmob/ArticleList' => 'wmmob/articlelist',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //http://dev-ejm.hkej.com/monthly/article/id/2382845
                '<controller:\w+>/<action:\w+>/id/<id:\d+>' => '<controller>/<action>',

                //featuresmob/category/code/1
                '<controller:\w+>/<action:\w+>/code/<code:\d+>' => '<controller>/<action>',
                //featuresmob/topic/tag/食家講場
                '<controller:\w+>/<action:\w+>/tag/<tag>' => '<controller>/<action>',
                //multimediamob/finance/tag/EJ%20Markets
                //'<controller:\w+>/<action:\w+>/tag/<tag:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/tag/<tag:[a-zA-Z \-]+>' => '<controller>/<action>',
                //dailynews article rules
                '<controller:\w+>/headline/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/headline/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/investment/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/investment/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/finnews/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/finnews/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/commentary/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/commentary/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/culture/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/culture/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/property/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/property/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/politics/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/politics/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/views/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/views/<action:\w+>/<id:\d+>' => '<controller>/<action>',                
                '<controller:\w+>/cntw/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/cntw/<action:\w+>/<id:\d+>' => '<controller>/<action>',                
                '<controller:\w+>/international/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/international/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                //onlinenews article rules
                '<controller:\w+>/stock/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/hongkong/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/property/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/china/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/international/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/current/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/market/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/announcement/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                '<controller:\w+>/hkex/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                //property article rules
                '<controller:\w+>/property/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
                'property/AuthorDetail' => 'property/authordetail',
                //property/details/estate/海怡半島
                '<controller:\w+>/<action:\w+>/estate/<estate>' => '<controller>/<action>',
                //'<controller:\w+>/hkex/<action:\w+>/<id:\d+>/<subjectline:[a-zA-Z \-]+>' => '<controller>/<action>',
                //wm article rules
                '<controller:\w+>/wm/<action:\w+>/<id:\d+>/<subjectline>' => '<controller>/<action>',
            ],

            /*
            'rules' => [
                  'landingMob' => 'landingMob/index',
                  '<controller:\w+>/<id:\d+>' => '<controller>/view',
                  '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                  '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],*/
            
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
        ],        

        /*'simplehtmldom' => [
            'class' => '\serhatozles\yii2-simplehtmldom\SimpleHTMLDom'
        ],*/        

        //'db' => require(__DIR__ . '/db.php'),
        //'db' => require(__DIR__ . '/dbAurora.php'),
        'nejdb1' => require(__DIR__ . '/dbMainsiteRemoteWeb.php'),
        'nejlocalweb' => require(__DIR__ . '/dbMainsiteLocalWeb.php'),
        'dbaurora' => require(__DIR__ . '/dbAurora.php'),
        'dbauroralj' => require(__DIR__ . '/dbAuroralj.php'),
        'timeZone' => 'Asia/Hong Kong',
    ],
    'params' => $params,
    //'defaultRoute'=>'site/index',
    'defaultRoute'=>'monthly/index',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1' ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1' ],
    ];
}

return $config;
