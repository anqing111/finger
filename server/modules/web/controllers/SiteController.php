<?php

namespace app\modules\web\controllers;

use app\models\db\BArticle;
use app\models\db\BBanner;
use app\models\db\BCclive;
use app\models\db\BJoin;
use app\models\db\BProfessional;
use app\models\db\BUserbaseinfo;
use app\models\db\EInstructor;
use app\models\db\EStudentopus;
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

        //获取网站咨询类文章
        $article = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
        $article3 = $article5 = $ids = $ids3 = [];
        foreach ($article as $r)
        {
            $ids[] = $r->id;
        }
        //获取热点网站咨询类文章
        if(count($ids) > \Yii::$app->params['article']['INFORMATION_TYPE'])
        {
            $article3 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE],['not in',['id'],[implode(',',$ids)]]])->orderBy('click desc')->limit(\Yii::$app->params['article']['RE_INFORMATION_TYPE'])->all();
        }
        //获取我们排序从高到低的网站咨询类文章
        foreach ($article3 as $r3)
        {
            $ids3[] = $r3->id;
        }

        if(count($ids3) > \Yii::$app->params['article']['RE_INFORMATION_TYPE'])
        {
            $ids3 = array_merge($ids,$ids3);
            $article5 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE],['not in',['id'],[implode(',',$ids3)]]])->orderBy('index desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
        }

        $article4 = $article6 = $ids2 = $ids4 = [];
        //技能薪酬类文章
        $article2 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['TECHNICAL_TYPE'])->all();
        foreach ($article2 as $r2)
        {
            $ids2[] = $r2->id;
        }
        if(count($ids2) > \Yii::$app->params['article']['TECHNICAL_TYPE'])
        {
            $article4 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE],['not in',['id'],[implode(',',$ids2)]]])->orderBy('id desc')->limit(\Yii::$app->params['article']['RE_TECHNICAL_TYPE'])->all();
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
        //获取学生作品秀视频
        $studentopus = EStudentopus::find()->andWhere(['and',['isRec'=>EStudentopus::YES]])->orderBy('id desc')->all();
        //获取学生专业技能
        $professional = BProfessional::find()->andWhere(['and',['isRec'=>EStudentopus::YES]])->orderBy('id desc')->all();
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
            'studentopus'=>$studentopus,
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
        $this->redirect(array('/web/site/login'));
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
            if(empty($get['sMail']) || empty($get['iUserID']) || empty($get['token']) || empty($get['time']) || empty($get['token']))
            {
                //跳转到错误页面
                $this->redirect(array('/web/site/error'));
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
                    $this->redirect(array('/web/site/error'));
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
                    \Yii::$app->session->set($current.'phone',$account);
                }else{
                    //邮箱验证码
                    $mail= \Yii::$app->mailer->compose();
                    $mail->setTo($account);
                    $mail->setSubject("邮件测试");
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

            self::getSucInfo(['ok'=>true],$this->method);
        }

        return $this->renderPartial('joinindex');
    }

    //错误页面
    public function actionError()
    {
        return $this->renderPartial('error');
    }
}
