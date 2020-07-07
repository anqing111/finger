<?php

namespace app\modules\web\controllers;

use app\models\db\BJoin;
use yii\web\Controller;

/**
 * Default controller for the `web` module
 */
class SiteController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     * 申请加盟
     */
    public function actionJoinindex()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('单位名称不得为空',$this->method);
            }

            if(false == BJoin::insertJoin($post))
            {
                self::getFailInfo('申请加盟添加失败',$this->method);
            }
        }

        return $this->render('joinindex');
    }
}
