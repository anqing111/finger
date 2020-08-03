<?php

namespace app\modules\web\controllers;

use app\models\db\BArticle;
use app\models\db\BBanner;
use app\models\db\BCclive;
use app\models\db\BCity;
use app\models\db\BCourse;
use app\models\db\BIndustry;
use app\models\db\BJoin;
use app\models\db\BProfessional;
use app\models\db\BTrainingvideo;
use app\models\db\BUniversity;
use app\models\db\BUserbaseinfo;
use app\models\db\BVideo;
use app\models\db\EInstructor;
use app\models\db\EStudentcertificate;
use app\models\db\EStudentopus;
use app\models\SMSForm;
use yii\db\Exception;
use yii\web\Controller;

/**
 * Default controller for the `web` module
 */
class SiteController extends BaseController
{
    //首页
    public function actionIndex()
    {
        //获取banner轮播图
        $today = date('Y-m-d H:i:s');
        $banner = BBanner::find()->andWhere(['and',['status'=>BBanner::PUBLISHED],['<','date_from',$today],['>','date_to',$today]])->orderBy('id desc')->all();
        //获取专家/讲师简介（讲师秀）
        $instructor = EInstructor::find()->andWhere(['isRec'=>EInstructor::YES])->orderBy('id')->limit(\Yii::$app->params['teacher'])->all();

        /*
         * 暂时按isHot标识热门文章，后续文章多了按点击率标识热门文章
         * */
        //获取网站咨询类文章
//        $article = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
//        $article3 = $article5 = $ids = $ids3 = [];
//        foreach ($article as $r)
//        {
//            $ids[] = $r->id;
//        }
//        //获取热点网站咨询类文章
//        if(count($ids) > \Yii::$app->params['article']['INFORMATION_TYPE'])
//        {
//            $article3 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE],['not in',['id'],[implode(',',$ids)]]])->orderBy('click desc')->limit(\Yii::$app->params['article']['RE_INFORMATION_TYPE'])->all();
//        }
//        //获取我们排序从高到低的网站咨询类文章
//        foreach ($article3 as $r3)
//        {
//            $ids3[] = $r3->id;
//        }
//
//        if(count($ids3) > \Yii::$app->params['article']['RE_INFORMATION_TYPE'])
//        {
//            $ids3 = array_merge($ids,$ids3);
//            $article5 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE],['not in',['id'],[implode(',',$ids3)]]])->orderBy('index desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
//        }
//
//        $article4 = $article6 = $ids2 = $ids4 = [];
//        //技能薪酬类文章
//        $article2 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['TECHNICAL_TYPE'])->all();
//        foreach ($article2 as $r2)
//        {
//            $ids2[] = $r2->id;
//        }
//        if(count($ids2) > \Yii::$app->params['article']['TECHNICAL_TYPE'])
//        {
//            $article4 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE],['not in',['id'],[implode(',',$ids2)]]])->orderBy('id desc')->limit(\Yii::$app->params['article']['RE_TECHNICAL_TYPE'])->all();
//        }
//        //获取我们排序从高到低的技能薪酬类文章
//        foreach ($article4 as $r4)
//        {
//            $ids4[] = $r4->id;
//        }
//
//        if(count($ids4) > \Yii::$app->params['article']['RE_TECHNICAL_TYPE'])
//        {
//            $ids4 = array_merge($ids2,$ids4);
//            $article6 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE],['not in',['id'],[implode(',',$ids4)]]])->orderBy('index desc')->limit(\Yii::$app->params['article']['TECHNICAL_TYPE'])->all();
//        }
        $article = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['isHot'=>BArticle::NO],['type'=>BArticle::INFORMATION_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
        $article5 = $ids = $ids3 = [];
        //获取热点网站咨询类文章
        $article3 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['isHot'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE]])->orderBy('click desc')->limit(\Yii::$app->params['article']['RE_INFORMATION_TYPE'])->all();
        //获取我们排序从高到低的网站咨询类文章
        foreach ($article as $r)
        {
            $ids[] = $r->id;
        }
        foreach ($article3 as $r3)
        {
            $ids3[] = $r3->id;
        }

        if(count($ids3) > \Yii::$app->params['article']['RE_INFORMATION_TYPE'])
        {
            $ids3 = array_merge($ids,$ids3);
            $article5 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE],['not in',['id'],[implode(',',$ids3)]]])->orderBy('index desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
        }

        $article6 = $ids2 = $ids4 = [];
        //技能薪酬类文章
        $article2 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['isHot'=>BArticle::NO],['type'=>BArticle::TECHNICAL_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['TECHNICAL_TYPE'])->all();
        $article4 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['isHot'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['RE_TECHNICAL_TYPE'])->all();
        foreach ($article2 as $r2)
        {
            $ids2[] = $r2->id;
        }
        //获取我们排序从高到低的技能薪酬类文章
        foreach ($article4 as $r4)
        {
            $ids4[] = $r4->id;
        }

        if(count($ids4) > \Yii::$app->params['article']['RE_TECHNICAL_TYPE'])
        {
            $ids4 = array_merge($ids2,$ids4);
            $article6 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE],['not in',['id'],[implode(',',$ids4)]]])->orderBy('index desc')->limit(\Yii::$app->params['article']['TECHNICAL_TYPE'])->all();
        }
        //获取直播
        $cclive = BCclive::find()->where(['status'=>BCclive::NORMAL])->orderBy('liveStartTime')->asArray()->all();
        //获取学习视频
        $video = BVideo::find()->andWhere(['and',['isRec'=>EStudentopus::YES]])->orderBy('id desc')->limit(\Yii::$app->params['opus'])->all();
        //获取学生专业技能
        $professional = BProfessional::find()->andWhere(['and',['isRec'=>BProfessional::YES]])->orderBy('id desc')->limit(\Yii::$app->params['skill'])->all();
        return $this->renderPartial('index',[
            'banner'=>$banner,
            'cclive'=>$cclive,
            'instructor'=>$instructor,
            'article'=>$article,
            'article2'=>$article2,
            'article3'=>$article3,
            'article4'=>$article4,
            'article5'=>$article5,
            'article6'=>$article6,
            'video'=>$video,
            'professional'=>$professional,
        ]);
    }
    //登录
    public function actionLogin()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(!empty($post['account']) && !empty($post['sPassWord']))
            {
                $account = $post['account'];
                //密钥加密
                $user = BUserbaseinfo::find()->where(['or',['sMail'=>$account],['sPhone'=>$account]])->one();
                if(!$user)
                {
                    self::getFailInfo('账号或密码错误',$this->method);
                }
                $sPassWord = base64_decode($user->sPassWord);
                $sPassWord = \Yii::$app->getSecurity()->decryptByPassword($sPassWord, \Yii::$app->params['secretKey']);
                if($sPassWord !== $post['sPassWord'])
                {
                    self::getFailInfo('账号或密码错误',$this->method);
                }
            }else{
                self::getFailInfo('账号或密码不能为空',$this->method);
            }
            //添加session
            \Yii::$app->session->set('sNick',$user->sNick);
            \Yii::$app->session->set('iUserID',$user->iUserID);
            \Yii::$app->session->set('pid',$user->pid);

            self::getSucInfo(['url'=>'site'],$this->method);

        }
        return $this->renderPartial('login');
    }
    //退出
    public function actionLogout()
    {
        //移除session
        \Yii::$app->session->remove('sNick');
        \Yii::$app->session->remove('iUserID');
        \Yii::$app->session->remove('pid');
        header('location:index.php?r=web/site/login');
    }
    //注册
    public function actionRegister()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(!preg_match(\Yii::$app->params['preg_match']['email'],$post["sMail"])){
                self::getFailInfo("邮箱格式不正确",$this->method);
            }

            $current = $post['source'];
            $session_mail = \Yii::$app->session->get($current.'email');
            if($post['sMail']!=$session_mail)
            {
                self::getFailInfo('您输入的邮箱与发送验证码的邮箱不一致',$this->method);
            }

            //验证邮箱验证码
            $code = \Yii::$app->session->get($current.'code');

            if(empty($code) || $post['code'] != $code)
            {
                self::getFailInfo('邮箱验证码不正确',$this->method);
            }

            if(!preg_match(\Yii::$app->params['preg_match']['password'],$post["sPassWord"])){
                self::getFailInfo("请输入6-15位数字或字母密码",$this->method);
            }

            //验证手机号/邮箱是否唯一
            $user = BUserbaseinfo::find()->where(['sMail'=>$post['sMail']])->one();
            if($user)
            {
                self::getFailInfo('用户添加失败该邮箱已经存在',$this->method);
            }

            //密钥加密
            $post['sPassWord'] = base64_encode(\Yii::$app->getSecurity()->encryptByPassword($post['sPassWord'], \Yii::$app->params['secretKey']));
            $post['dUpdateTime'] = date('Y-m-d H:i:s');

            //添加
            $iUserID = BUserbaseinfo::insertBaseUserInfo($post);
            if(false == $iUserID)
            {
                self::getFailInfo('用户添加失败',$this->method);
            }

            //添加session
            \Yii::$app->session->set('sNick',$post['sNick']);
            \Yii::$app->session->set('iUserID',$iUserID);
            \Yii::$app->session->set('pid',BUserbaseinfo::STUDENT);

            $arPara = [
                'iUserID'=>$iUserID,
                'sMail'=>$post['sMail'],
            ];

            $arStr = array();

            foreach ($arPara as $key => $v) {
                $arStr[] = $key . "=" . $v;
            }

            $url = implode('&',$arStr);
            $time = time();
            $signMsg = md5($url.'&time='.$time.'&salt='.\Yii::$app->params['secretKey']);

            $url = 'index.php?r=web/site/banding&sMail='.$arPara['sMail'].'&iUserID='.$arPara['iUserID'].'&time='.$time.'&token='.$signMsg;
            self::getSucInfo(['url'=>$url],$this->method);

        }
        return $this->renderPartial('register');
    }
    //绑定手机号
    public function actionBanding()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(!preg_match(\Yii::$app->params['preg_match']['phone'],$post["sPhone"])){
                self::getFailInfo("手机号格式不正确",$this->method);
            }

            $current = $post['source'];
            $session_phone = \Yii::$app->session->get($current.'phone');
            if($post['sPhone']!=$session_phone)
            {
                self::getFailInfo('您输入的手机号与发送验证码的手机号不一致',$this->method);
            }

            //验证邮箱验证码
            $code = \Yii::$app->session->get($current.'code');

            if(empty($code) || $post['code'] != $code)
            {
                self::getFailInfo('短信验证码不正确',$this->method);
            }

            //验证手机号是否唯一
            $userold = BUserbaseinfo::find()->where(['sPhone'=>$post['sPhone']])->one();
            if($userold)
            {
                self::getFailInfo('用户绑定手机号失败该手机号已经存在',$this->method);
            }

            //判断数据存不存在
            $user = BUserbaseinfo::findOne($post['iUserID']);
            if(!$user)
            {
                self::getFailInfo('该用户不存在',$this->method);
            }

            if($user->sMail != $post['sMail'])
            {
                self::getFailInfo('该用户不存在',$this->method);
            }

            //编辑
            if(false == BUserbaseinfo::updateBaseUserInfo($post))
            {
                self::getFailInfo('用户绑定手机号失败',$this->method);
            }

            self::getSucInfo(['url'=>'index.php?r=web/site/success'],$this->method);

        }else{
            $get = \Yii::$app->request->get();
            if(empty($get['sMail']) || empty($get['iUserID']) || empty($get['time']) || empty($get['token']))
            {
                //跳转到错误页面
//                $this->redirect(array('/web/site/error'));
                header('location:index.php?r=web/site/error');
            }else{
                $arPara = [
                    'iUserID'=>$get['iUserID'],
                    'sMail'=>$get['sMail'],
                ];

                $arStr = array();

                foreach ($arPara as $key => $v) {
                    $arStr[] = $key . "=" . $v;
                }

                $url = implode('&',$arStr);
                $time = $get['time'];
                $signMsg = md5($url.'&time='.$time.'&salt='.\Yii::$app->params['secretKey']);

                if($signMsg != $get['token'])
                {
                    //跳转到错误页面
//                    $this->redirect(array('/web/site/error'));
                    header('location:index.php?r=web/site/error');
                }else{
                    return $this->renderPartial('banding',['iUserID'=>$get['iUserID'],'sMail'=>$get['sMail']]);
                }
            }
        }
    }
    //注册成功页
    public function actionSuccess()
    {
        return $this->renderPartial('success');
    }
    //忘记密码-邮箱找回
    public function actionForgetmail()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(!preg_match(\Yii::$app->params['preg_match']['email'],$post["sMail"])){
                self::getFailInfo("邮箱格式不正确",$this->method);
            }

            $current = $post['source'];
            $session_mail = \Yii::$app->session->get($current.'email');
            if($post['sMail']!=$session_mail)
            {
                self::getFailInfo('您输入的邮箱与发送验证码的邮箱不一致',$this->method);
            }

            //验证邮箱验证码
            $code = \Yii::$app->session->get($current.'code');

            if(empty($code) || $post['code'] != $code)
            {
                self::getFailInfo('邮箱验证码不正确',$this->method);
            }

            if(!preg_match(\Yii::$app->params['preg_match']['password'],$post["sPassWord"])){
                self::getFailInfo("请输入6-15位数字或字母密码",$this->method);
            }

            if($post["sPassWord"] != $post['word'])
            {
                self::getFailInfo("两次密码输入不一致",$this->method);
            }

            //验证手机号/邮箱是否唯一
            $user = BUserbaseinfo::find()->where(['sMail'=>$post['sMail']])->one();
            if(!$user)
            {
                self::getFailInfo('该邮箱不存在',$this->method);
            }

            //密钥加密
            $post['sPassWord'] = base64_encode(\Yii::$app->getSecurity()->encryptByPassword($post['sPassWord'], \Yii::$app->params['secretKey']));
            $post['dUpdateTime'] = date('Y-m-d H:i:s');
            $post['iUserID'] = $user['iUserID'];

            //编辑
            if(false == BUserbaseinfo::updateBaseUserInfo($post))
            {
                self::getFailInfo('用户编辑失败',$this->method);
            }

            //添加session
            \Yii::$app->session->set('sNick',$user['sNick']);
            \Yii::$app->session->set('iUserID',$user['iUserID']);
            \Yii::$app->session->set('pid',$user['pid']);

            $url = 'index.php?r=web/site/forgetsuccess';
            self::getSucInfo(['url'=>$url],$this->method);

        }
        return $this->renderPartial('forgetmail');
    }
    //忘记密码-手机号找回
    public function actionForgetphone()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(!preg_match(\Yii::$app->params['preg_match']['phone'],$post["sPhone"])){
                self::getFailInfo("手机号格式不正确",$this->method);
            }

            $current = $post['source'];
            $session_phone = \Yii::$app->session->get($current.'phone');
            if($post['sPhone']!=$session_phone)
            {
                self::getFailInfo('您输入的手机号与发送验证码的手机号不一致',$this->method);
            }

            //验证邮箱验证码
            $code = \Yii::$app->session->get($current.'code');

            if(empty($code) || $post['code'] != $code)
            {
                self::getFailInfo('短信验证码不正确',$this->method);
            }

            if(!preg_match(\Yii::$app->params['preg_match']['password'],$post["sPassWord"])){
                self::getFailInfo("请输入6-15位数字或字母密码",$this->method);
            }

            if($post["sPassWord"] != $post['word'])
            {
                self::getFailInfo("两次密码输入不一致",$this->method);
            }

            //验证手机号是否唯一
            $user = BUserbaseinfo::find()->where(['sPhone'=>$post['sPhone']])->one();
            if(!$user)
            {
                self::getFailInfo('该手机号不存在',$this->method);
            }

            //密钥加密
            $post['sPassWord'] = base64_encode(\Yii::$app->getSecurity()->encryptByPassword($post['sPassWord'], \Yii::$app->params['secretKey']));
            $post['dUpdateTime'] = date('Y-m-d H:i:s');
            $post['iUserID'] = $user['iUserID'];

            //编辑
            if(false == BUserbaseinfo::updateBaseUserInfo($post))
            {
                self::getFailInfo('用户编辑失败',$this->method);
            }

            //添加session
            \Yii::$app->session->set('sNick',$user['sNick']);
            \Yii::$app->session->set('iUserID',$user['iUserID']);
            \Yii::$app->session->set('pid',$user['pid']);

            $url = 'index.php?r=web/site/forgetsuccess';
            self::getSucInfo(['url'=>$url],$this->method);

        }
        return $this->renderPartial('forgetphone');
    }
    //忘记密码-成功页
    public function actionForgetsuccess()
    {
        return $this->renderPartial('forgetsuccess');
    }
    //发送短信/邮箱验证码
    public function actionSendcode()
    {
        if(\Yii::$app->request->isPost)
        {
            $current = \Yii::$app->request->post('source');
            $GetMesValidate_time = \Yii::$app->session->get($current.'GetMesValidate_time');

            if((60-(time()-$GetMesValidate_time))>0)
            {
                \Yii::$app->session->set($current.'GetMesValidate',60-(time()-$GetMesValidate_time));
                $GetMesValidate = \Yii::$app->session->get($current.'GetMesValidate');

                if(!isset($GetMesValidate)||empty($GetMesValidate)||$GetMesValidate==1){

                }else{
                    self::getFailInfo('验证码已经发送，请等待验证码失效',$this->method);
                }
            }

            $randStr = str_shuffle('1234567890');
            $code = substr($randStr,0,6);
            $account = \Yii::$app->request->post('account');
            //默认发送邮箱验证码
            try{
                if(strpos($current,'message') !== false){
                    //短信验证码
                    $arPara = array('code'=>$code);
                    $sTemplate = 'SMS_196643077';
                    $sPhone = $account;
                    $res = SMSForm::sendDayuTextMsg($sPhone,$arPara,$sTemplate);
                    if($res == 1)
                    {
                        \Yii::$app->session->set($current.'phone',$account);
                    }else{
                        self::getFailInfo('验证码发送失败请稍后重试',$this->method);
                    }
                }else{
                    //邮箱验证码
                    $mail= \Yii::$app->mailer->compose();
                    $mail->setTo($account);
                    $mail->setSubject("八泽国际");
                    $mail->setTextBody('邮箱验证码：'.$code);   //发布纯文字文本
//                $mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
                    if(@$mail->send())
                    {
                        \Yii::$app->session->set($current.'email',$account);
                    }
                    else
                        throw new \Exception('第一次错误');
                }
            }catch (Exception $exception){
                echo $exception->getMessage();
            }

            \Yii::$app->session->set($current.'code',$code);
            \Yii::$app->session->set($current.'GetMesValidate',60);
            \Yii::$app->session->set($current.'GetMesValidate_time',time());
            self::getSucInfo(["time"=>60],$this->method);
        }
    }
    /*
     * 获取验证码
     * */
    public function actionGetmesvalidate()
    {
        if(\Yii::$app->request->isPost)
        {
            $current = \Yii::$app->request->post('source');
            $GetMesValidate_time = \Yii::$app->session->get($current.'GetMesValidate_time');
            if((60-(time()-$GetMesValidate_time))>0){

                \Yii::$app->session->set($current.'GetMesValidate',60-(time()-$GetMesValidate_time));
                $GetMesValidate = \Yii::$app->session->get($current.'GetMesValidate');
                if(!isset($GetMesValidate)||empty($GetMesValidate)||$GetMesValidate==1){

                    $res = array('time'=>0);
                }else{
                    $res = array('time'=>$GetMesValidate);

                }

            }else{
                $res = array('time'=>0);
            }

            self::getSucInfo($res,$this->method);
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
                //判断证书是否审核通过
                if($cert->status == EStudentcertificate::UNDERREVIEW) //审核中
                {
                    self::getFailInfo('证书正在审核中...',$this->method);
                }

                if($cert->status == EStudentcertificate::FILED) //审核未通过
                {
                    self::getFailInfo('证书审核失败请重新提交审核...',$this->method);
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

            $url = 'index.php?r=web/site/certificateinfo&idcard='.base64_encode($arPara['idcard'].'@@'.\Yii::$app->params['secretKey']).'&sCertificateNum='.base64_encode($arPara['sCertificateNum'].'@@'.\Yii::$app->params['secretKey']).'&time='.$time.'&token='.$signMsg;
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
//            $this->redirect(array('/web/site/error'));
            header('location:index.php?r=web/site/error');
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
//                $this->redirect(array('/web/site/error'));
                header('location:index.php?r=web/site/error');
            }else{
                $cert = EStudentcertificate::find()->where(['and',['idcard'=>$arPara['idcard']],['sCertificateNum'=>$arPara['sCertificateNum']]])->one();
                if(!$cert)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/web/site/error'));
                    header('location:index.php?r=web/site/error');
                }else{
                    $video = BVideo::find()->where(['iUserID'=>$cert->iUserID])->all();
                    return $this->renderPartial('certificateinfo',['cert'=>$cert,'video'=>$video]);
                }
            }
        }
    }
    /**
     * Renders the index view for the module
     * @return string
     * 申请加盟
     */
    public function actionJoin()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('单位名称不得为空',$this->method);
            }

            //获取城市名称
            $city = BCity::findOne($post['iCityID']);
            if($city)
            {
                $post['sCityName'] = $city->sCityName;
            }

            $sPassWord = rand(100000,999999);
            $join = BJoin::find()->orderBy('joinNum desc')->one();
            if(!empty($join))
            {
                $post['joinNum'] = $join->joinNum + 1;
            }else{
                $post['joinNum'] = 10001;
            }
            //密钥加密
            $post['sPassWord'] = base64_encode(\Yii::$app->getSecurity()->encryptByPassword($sPassWord, \Yii::$app->params['secretKey']));

            if(false == BJoin::insertJoin($post))
            {
                self::getFailInfo('申请加盟添加失败',$this->method);
            }

            self::getSucInfo(['ok'=>true],$this->method);
        }
        //获取城市列表
        $city = BCity::find()->orderBy('sCityPY')->all();
        return $this->renderPartial('join',['city'=>$city]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 学校简介
     */
    public function actionCollege()
    {
        //获取学校列表
        $university = BUniversity::find()->where(['status'=>BUniversity::PUBLISHED])->orderBy('id desc')->one();
        return $this->renderPartial('college',['university'=>$university]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 全部文章
     */
    public function actionArticlelist()
    {
        //获取文章列表
        $article = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['type'=>BArticle::INFORMATION_TYPE]])->orderBy('id desc')->all();
        //获取文章列表
        $article2 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['type'=>BArticle::TECHNICAL_TYPE]])->orderBy('id desc')->all();
        //获取热门文章
        $article3 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isHot'=>BArticle::YES]])->orderBy('click desc')->all();

        return $this->renderPartial('article',['article'=>$article,'article2'=>$article2,'article3'=>$article3]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 文章详情
     */
    public function actionArticleinfo()
    {
        //获取文章详情
        if(!\Yii::$app->request->get('id'))
        {
            //跳转到错误页面
//            $this->redirect(array('/web/site/error'));
            header('location:index.php?r=web/site/error');
        }else{
            $id = \Yii::$app->request->get('id');
            if(!is_numeric($id))
            {
                //跳转到错误页面
//                $this->redirect(array('/web/site/error'));
                header('location:index.php?r=web/site/error');
            }else{
                $article = BArticle::findOne($id);
                if(!$article)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/web/site/error'));
                    header('location:index.php?r=web/site/error');
                }else{
                    return $this->renderPartial('articleinfo',['article'=>$article]);
                }
            }
        }
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
//            $this->redirect(array('/web/site/error'));
            header('location:index.php?r=web/site/error');
        }else{
            $id = \Yii::$app->request->get('id');
            if(!is_numeric($id))
            {
                //跳转到错误页面
//                $this->redirect(array('/web/site/error'));
                header('location:index.php?r=web/site/error');
            }else{
                $instructor = EInstructor::getInstructor([EInstructor::tableName().'.id'=>$id]);
                if(!$instructor)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/web/site/error'));
                    header('location:index.php?r=web/site/error');
                }else{
                    return $this->renderPartial('instructorinfo',['instructor'=>$instructor]);
                }
            }
        }
    }
    /**
     * Renders the index view for the module
     * @return string
     * 全部课程
     */
    public function actionCourseindex()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(!isset($post['tid']) || !is_numeric($post['tid']))
            {
                self::getFailInfo('请选择课程类别',$this->method);
            }

            if($post['tid'] > 0)
            {
                $course = BCourse::find()->andWhere(['and',['status'=>BCourse::PUBLISHED],['tid'=>$post['tid']]])->orderBy('id desc')->asArray()->all();
            }else{
                $course = BCourse::find()->andWhere(['status'=>BCourse::PUBLISHED])->orderBy('id desc')->asArray()->all();
            }

            self::getSucInfo(['course'=>$course],$this->method);
        }
        //全部类别
        $industr = BIndustry::find()->where(['>','industryID','0'])->orderBy('id desc ')->all();
        //全部课程
        $course = BCourse::find()->andWhere(['status'=>BCourse::PUBLISHED])->orderBy('id desc')->all();
        return $this->renderPartial('courseindex',['course'=>$course,'industr'=>$industr]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 课程详情
     */
    public function actionCourseinfo()
    {
        if(!\Yii::$app->request->get('id'))
        {
            //跳转到错误页面
//            $this->redirect(array('/web/site/error'));
            header('location:index.php?r=web/site/error');
        }else{
            $id = \Yii::$app->request->get('id');
            if(!is_numeric($id))
            {
                //跳转到错误页面
//                $this->redirect(array('/web/site/error'));
                header('location:index.php?r=web/site/error');
            }else{
                $course = BCourse::find()->where(['and',['id'=>$id],['status'=>BCourse::PUBLISHED]])->asArray()->one();
                if(!$course)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/web/site/error'));
                    header('location:index.php?r=web/site/error');
                }else{
                    //获取章节
                    $course['trainingvideo'] = [];
                    $video = BTrainingvideo::find()->where(['and',['cid'=>$id],['status'=>BTrainingvideo::PUBLISHED]])->orderBy('id asc')->all();
                    if(!empty($video))
                    {
                        $course['trainingvideo'] = $video;
                    }

                    return $this->renderPartial('courseinfo',['course'=>$course]);
                }
            }
        }
    }
    //错误页面
    public function actionError()
    {
        return $this->renderPartial('error');
    }
}
