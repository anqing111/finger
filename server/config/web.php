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
        '@views' => '@app/views',
        '@common' => '@app/common',
        '@waproot' => '@app/wap',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mWAA-P9RN9L-6Zb0A_CcYO5Oa5p9nBkP',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'web/site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',  //每种邮箱的host配置不一样
                'username' => '13393072310@163.com',
                'password' => 'ITTHCLZPGLOXEUIN',
                'port' => '465',
                'encryption' => 'ssl',

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['13393072310@163.com'=>'AnQing']
            ],
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
        'db' => $db,
        /*
        'urlManager' => [
                        'enablePrettyUrl' => true,
                        'showScriptName' => false,
                        'enableStrictParsing' => true,
                        'suffix' => ".html",
                        'rules' => [ '' => 'site/index', // 如果没有这里，则访问域名不能直接打开默认Action
                        ]
                ]
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

$config['modules']['web'] = ['class' => 'app\modules\web\Module'];
$config['modules']['wap'] = ['class' => 'app\modules\wap\Module'];

//yii2嵌入富文本编辑器
$config['modules']['redactor'] = [
    'class' => 'yii\redactor\RedactorModule',
    'uploadDir' => '@common/redactor',
    'uploadUrl' => $params['imagePath'].'/common/redactor',
    'imageAllowExtensions'=>['jpg','png','gif'],
];

return $config;
