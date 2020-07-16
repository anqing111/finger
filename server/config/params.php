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
    'baseUrl' => 'http://www.mybaze.com/',
    'secretKey'=>'finger',
    //前端ajax调用密钥
    'KEY'=>'a7976b01a29bf6f1a261a69583c4df5e',
    'MERCODE'=>'fingertip',
    //接口方
    'interface'=>[
        'cclive'=>1
    ],
    //正则表达式配置
    'preg_match'=> [
        "phone"=>"/^1[23456789]{1}\d{9}$/",
        "email"=>"/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i",
        "positiveInteger"=>"/^([1-9][0-9]{0,9})$/", //正整数
        "percent"=>"/^(([0-9]|([1-9][0-9]{0,1}))((\.[0-9]{1})?))$/", //百分数
        "number"=>"/^(([0-9]|([1-9][0-9]{0,9}))((\.[0-9]{1,2})?))$/", //保留2位有效数字
        "tel"=>"/^([0-9]{3,4}-)?([0-9]{3,4}-)?[0-9]{4,8}$/", //固定电话
        "password"=>"/^[0-9A-Za-z]{6,15}$/",//密码验证
    ],
    //前端文章数量显示
    'article'=>[
        'INFORMATION_TYPE'=>10,
        'TECHNICAL_TYPE'=>10,
        'RE_INFORMATION_TYPE'=>13,
        'RE_TECHNICAL_TYPE'=>13,
    ],
    //前端讲师秀展示
    'teacher'=>9,
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
