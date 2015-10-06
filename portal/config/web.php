<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [
           'enablePrettyUrl' => true,
           'showScriptName' => false,
           'hostinfo' => 'http://gmod.wsu.edu',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gvnW2SWdD0BiPlCVhyjb5aoACsBsJjb6',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //'user' => [
        //    'identityClass' => 'app\models\User',
        //    'enableAutoLogin' => true,
        //],
        //'authClientCollection' => [
        //    'class' => 'yii\authclient\Collection',
        //    'clients' => [
        //        'class' => 'yii\authclient\clients\GoogleOAuth',
        //        'clientId' => 'xxxxxxxxxx',
        //        'clientSecret' => 'yyyyyyyyyy',                
        //        
        //        
        //        
        //    ],
        //],
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ],

            ],
        ],       
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
        ],
        //'gii' => [
        //    'yii\gii\Module',
        //    'allowedIPs' => ['127.0.0.1', '::1', '10.10.156.*'] // adjust this to your needs
        //],
        'gridview' => [
                       
            'class'=>'\kartik\grid\Module'
        ],
    ],
    
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
