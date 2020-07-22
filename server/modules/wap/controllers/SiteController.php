<?php

namespace app\modules\wap\controllers;

use app\models\db\BUniversity;
use app\models\db\EInstructor;
use app\models\db\EStudentcertificate;

/**
 * Default controller for the `wap` module
 */
class SiteController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
    /**
     * Renders the index view for the module
     * @return string
     * 全部专家
     */
    public function actionInstructor()
    {
        //获取专家/讲师简介（讲师秀）
        $instructor = EInstructor::find()->orderBy('id desc')->all();
        return $this->renderPartial('instructor',['instructor'=>$instructor]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 讲师秀详情
     */
    public function actionInstructorinfo()
    {
        //获取讲师秀详情
        if(!\Yii::$app->request->get('id'))
        {
            //跳转到错误页面
            $this->redirect(array('/wap/site/error'));
        }else{
            $id = \Yii::$app->request->get('id');
            if(!is_numeric($id))
            {
                //跳转到错误页面
                $this->redirect(array('/wap/site/error'));
            }else{
                $instructor = EInstructor::getInstructor([EInstructor::tableName().'.id'=>$id]);
                if(!$instructor)
                {
                    //跳转到错误页面
                    $this->redirect(array('/wap/site/error'));
                }else{
                    return $this->renderPartial('instructorinfo',['instructor'=>$instructor]);
                }
            }
        }
    }
    /*
     * 证书查询
     * */
    public function actionCertificateindex()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(!empty($post['idcard']) && !empty($post['sCertificateNum']))
            {
                $cert = EStudentcertificate::find()->where(['and',['idcard'=>$post['idcard']],['sCertificateNum'=>$post['sCertificateNum']]])->one();
                if(!$cert)
                {
                    self::getFailInfo('请输入正确的身份证号/证书编号',$this->method);
                }
            }else{
                self::getFailInfo('请输入正确的身份证号/证书编号',$this->method);
            }

            //跳转到证书查询结果页
            $arPara = [
                'idcard'=>$post['idcard'],
                'sCertificateNum'=>$post['sCertificateNum'],
            ];

            $arStr = array();

            foreach ($arPara as $key => $v) {
                $arStr[] = $key . "=" . $v;
            }

            $url = implode('&',$arStr);
            $time = time();
            $signMsg = md5($url.'&time='.$time.'&salt='.md5(\Yii::$app->params['secretKey'].$time));

            $url = 'index.php?r=wap/site/certificateinfo&idcard='.base64_encode($arPara['idcard'].'@@'.\Yii::$app->params['secretKey']).'&sCertificateNum='.base64_encode($arPara['sCertificateNum'].'@@'.\Yii::$app->params['secretKey']).'&time='.$time.'&token='.$signMsg;
            self::getSucInfo(['url'=>$url],$this->method);

        }
        return $this->renderPartial('certificateindex');
    }
    /*
     * 证书查询详情页
     * */
    public function actionCertificateinfo()
    {
        $get = \Yii::$app->request->get();
        if(empty($get['idcard']) || empty($get['sCertificateNum']) || empty($get['time']) || empty($get['token']))
        {
            //跳转到错误页面
            $this->redirect(array('/wap/site/error'));
        }else{
            $arPara = [
                'idcard'=>explode('@@',base64_decode($get['idcard']))[0],
                'sCertificateNum'=>explode('@@',base64_decode($get['sCertificateNum']))[0],
            ];
            $arStr = array();

            foreach ($arPara as $key => $v) {
                $arStr[] = $key . "=" . $v;
            }

            $url = implode('&',$arStr);
            $time = $get['time'];
            $signMsg = md5($url.'&time='.$time.'&salt='.md5(\Yii::$app->params['secretKey'].$time));

            if($signMsg != $get['token'])
            {
                //跳转到错误页面
                $this->redirect(array('/wap/site/error'));
            }else{
                $cert = EStudentcertificate::find()->where(['and',['idcard'=>$arPara['idcard']],['sCertificateNum'=>$arPara['sCertificateNum']]])->one();
                if(!$cert)
                {
                    //跳转到错误页面
                    $this->redirect(array('/wap/site/error'));
                }else{
                    return $this->renderPartial('certificateinfo',['cert'=>$cert]);
                }
            }
        }
    }
    /**
     * Renders the index view for the module
     * @return string
     * 学校简介
     */
    public function actionCollege()
    {
        //获取学校列表
        $university = BUniversity::findOne(2);
        return $this->renderPartial('college',['university'=>$university]);
    }
}
