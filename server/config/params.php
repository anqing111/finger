<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    // 必须在引导期间加载“log”组件
    'bootstrap' => ['log'],
    // “log”组件处理带时间戳的消息。 设置 PHP 时区以创建正确的时间戳
    'charset' => 'utf-8',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'imagePath' => 'http://image.mybaze.com',
    'components' => [
        'log' => [
            'targets' => [
//                [
//                    'class' => 'yii\log\DbTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//                [
//                    'class' => 'yii\log\EmailTarget',
//                    'levels' => ['error'],
//                    'categories' => ['yii\db\*'],
//                    'message' => [
//                        'from' => ['log@example.com'],
//                        'to' => ['admin@example.com', 'developer@example.com'],
//                        'subject' => 'Database errors at example.com',
//                    ],
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                    'logVars' => ['*'],
//                    //'categories' => ['application'],
//                    //'logFile' => '@runtime/logs/app.log',
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['pay'],
//                    'levels' => ['error', 'warning','info'],
//                    'logVars' => ['*'],
//                    'logFile' => '@runtime/logs/pay.log',
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['order'],
//                    'levels' => ['error', 'warning'],
//                    'logVars' => ['*'],
//                    'logFile' => '@runtime/logs/order.log',
//                ],
            ],
        ],
    ],
];
