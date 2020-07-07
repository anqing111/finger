<?php

namespace app\modules\web\controllers;

use app\models\db\EStudentcertificate;
use yii\web\Controller;

/**
 * Default controller for the `web` module
 */
class StudentController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     * 证书管理
     */
    public function actionStudentcertificateindex()
    {
        /*
         * 获取所有证书
         * */
        $iUserID = \Yii::$app->request->get('iUserID');
        if(!$iUserID)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $studentcertificate = EStudentcertificate::getStudentcertificate(['iUserID' => $iUserID]);

        return $this->render('studentcertificateindex');
    }
    /**
     * Renders the index view for the module
     * @return string
     * 证书管理-详情
     */
    public function actionStudentcertificateinfo()
    {
        /*
         * 获取证书详情
         * */
        $id = \Yii::$app->request->get('id');
        if(!$id)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $studentcertificate = EStudentcertificate::getStudentcertificate([EStudentcertificate::tableName().'id' => $id])[0];

        if(!$studentcertificate)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        return $this->render('studentcertificateinfo');

    }
    /**
     * Renders the index view for the module
     * @return string
     * 证书管理 - 编辑
     */
    public function actionStudentcertificateedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('证书名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == EStudentcertificate::updateStudentcertificate($post))
                {
                    self::getFailInfo('证书编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == EStudentcertificate::insertStudentcertificate($post))
                {
                    self::getFailInfo('证书添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);
        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $banner = EStudentcertificate::findOne($id);
                if(!$banner)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

    }
}
