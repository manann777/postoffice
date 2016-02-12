<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
         'view' => [
            'theme' =>[ 
                'pathMap'=>[
                    '@app/views'=>['@webroot/themes/bootflat']
                ],
                'baseUrl' => '@webroot/themes/bootflat',
            ]
        ],
        'timezone' => 'Asia/Bangkok',
        'language'=>'th_TH',
        //'urlManager' => ['enablePrettyUrl' => true],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '8I8-gK_mWMXwwp15f6hUxLVUpjQ5WqP8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    
    'params' => $params,
    'modules' => [
        'gridview' =>  [
        'class' => '\kartik\grid\Module',
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        //'downloadAction' => '\kartik\export\ExportMenu',
         /*'i18n' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@kvgrid/messages',
                    'forceTranslation' => true
                    ],*/
                ],

    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
//print_r($config);
return $config;
