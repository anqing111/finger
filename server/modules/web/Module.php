<?php

namespace app\modules\web;

/**
 * web module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\web\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        // 自定义错误页
        \Yii::$app->errorHandler->errorAction = 'web/site/error';
    }
}
