<?php

namespace app\modules\wap\controllers;

use app\models\db\BArticle;
use app\models\db\BBanner;
use app\models\db\BCclive;
use app\models\db\BCertificate;
use app\models\db\BCity;
use app\models\db\BCourse;
use app\models\db\BIndustry;
use app\models\db\BJoin;
use app\models\db\BProfessional;
use app\models\db\BTrainingvideo;
use app\models\db\BUniversity;
use app\models\db\BVideo;
use app\models\db\EInstructor;
use app\models\db\EStudentcertificate;
use app\models\db\EStudentopus;

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
        //获取banner轮播图
        $today = date('Y-m-d H:i:s');
        $banner = BBanner::find()->andWhere(['and',['status'=>BBanner::PUBLISHED],['<','date_from',$today],['>','date_to',$today]])->orderBy('id desc')->all();
        //获取专家/讲师简介（讲师秀）
        $instructor = EInstructor::find()->andWhere(['isRec'=>EInstructor::YES])->orderBy('id')->limit(4)->all();

        //获取网站咨询类文章
//        $article = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
//        $article3 = $ids = [];
//        foreach ($article as $r)
//        {
//            $ids[] = $r->id;
//        }
//        //获取热点网站咨询类文章
//        if(count($ids) > \Yii::$app->params['article']['INFORMATION_TYPE'])
//        {
//            $article3 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::INFORMATION_TYPE],['not in',['id'],[implode(',',$ids)]]])->orderBy('click desc')->limit(\Yii::$app->params['article']['RE_INFORMATION_TYPE'])->all();
//        }
//        //技能薪酬类文章
//        $article2 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['type'=>BArticle::TECHNICAL_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['TECHNICAL_TYPE'])->all();
        /*
         * 暂时以isHot作为热门标识  后续文章多了以点击量
         * */
        $article = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['isHot'=>BArticle::NO],['type'=>BArticle::INFORMATION_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['INFORMATION_TYPE'])->all();
        //获取热门文章
        $article3 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['isHot'=>BArticle::YES]])->orderBy('click desc')->limit(\Yii::$app->params['article']['RE_INFORMATION_TYPE'])->all();
        //技能薪酬类文章
        $article2 = BArticle::find()->andWhere(['and',['status'=>BArticle::PUBLISHED],['isRec'=>BArticle::YES],['isHot'=>BArticle::NO],['type'=>BArticle::TECHNICAL_TYPE]])->orderBy('id desc')->limit(\Yii::$app->params['article']['TECHNICAL_TYPE'])->all();

        //获取直播
        $cclive = BCclive::find()->where(['status'=>BCclive::NORMAL])->orderBy('liveStartTime')->asArray()->all();
        //获取学生学习视频
        $video = BVideo::find()->andWhere(['and',['isRec'=>EStudentopus::YES]])->orderBy('id desc')->limit(4)->all();
        //获取学生专业技能
        $professional = BProfessional::find()->andWhere(['and',['isRec'=>BProfessional::YES]])->orderBy('id desc')->limit(\Yii::$app->params['skill'])->all();
        return $this->renderPartial('index',[
            'banner'=>$banner,
            'cclive'=>$cclive,
            'instructor'=>$instructor,
            'article'=>$article,
            'article2'=>$article2,
            'article3'=>$article3,
            'video'=>$video,
            'professional'=>$professional,
        ]);
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
//            $this->redirect(array('/wap/site/error'));
            header('location:index.php?r=wap/site/error');
        }else{
            $id = \Yii::$app->request->get('id');
            if(!is_numeric($id))
            {
                //跳转到错误页面
//                $this->redirect(array('/wap/site/error'));
                header('location:index.php?r=wap/site/error');
            }else{
                $instructor = EInstructor::getInstructor([EInstructor::tableName().'.id'=>$id]);
                if(!$instructor)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/wap/site/error'));
                    header('location:index.php?r=wap/site/error');
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
//            $this->redirect(array('/wap/site/error'));
            header('location:index.php?r=wap/site/error');
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
//                $this->redirect(array('/wap/site/error'));
                header('location:index.php?r=wap/site/error');
            }else{
                $cert = EStudentcertificate::find()->where(['and',['idcard'=>$arPara['idcard']],['sCertificateNum'=>$arPara['sCertificateNum']]])->one();
                if(!$cert)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/wap/site/error'));
                    header('location:index.php?r=wap/site/error');
                }else{
                    $video = BVideo::find()->where(['iUserID'=>$cert->iUserID])->all();
                    return $this->renderPartial('certificateinfo',['cert'=>$cert,'video'=>$video]);
                }
            }
        }
    }
    /*
     * 我的证书-学员功能
     * */
    public function actionCertificatelist(){
        /*
         * 获取所有证书
         * */
        if(\Yii::$app->request->isPost)
        {
            $subjectName = '全部';
            $post = \Yii::$app->request->post();
            if(!isset($post['cid']) || !is_numeric($post['cid']))
            {
                self::getFailInfo('请选择证书类别',$this->method);
            }

            if($post['cid'] > 0)
            {
                $studentcertificate = EStudentcertificate::getStudentcertificate([EStudentcertificate::tableName().'.cid' => $post['cid']]);
                //获取类别
                $subjectName = BCertificate::findOne($post['cid'])->subjectName;
            }else{
                $studentcertificate = EStudentcertificate::getStudentcertificate(['and',[EStudentcertificate::tableName().'.iUserID' => $this->userid],[EStudentcertificate::tableName().'.status' => EStudentcertificate::PASSED]]);
                $studentcertificate = EStudentcertificate::getStudentcertificate();
            }

            foreach($studentcertificate as &$r)
            {
                //跳转到证书查询结果页
                $arPara = [
                    'idcard'=>$r['idcard'],
                    'sCertificateNum'=>$r['sCertificateNum'],
                ];

                $arStr = array();

                foreach ($arPara as $key => $v) {
                    $arStr[] = $key . "=" . $v;
                }

                $url = implode('&',$arStr);
                $time = time();
                $signMsg = md5($url.'&time='.$time.'&salt='.md5(\Yii::$app->params['secretKey'].$time));

                $r['url'] = 'index.php?r=wap/site/certificateinfo&idcard='.base64_encode($arPara['idcard'].'@@'.\Yii::$app->params['secretKey']).'&sCertificateNum='.base64_encode($arPara['sCertificateNum'].'@@'.\Yii::$app->params['secretKey']).'&time='.$time.'&token='.$signMsg;
            }

            self::getSucInfo(['cate'=>$studentcertificate,'subjectName'=>$subjectName],$this->method);
        }
        $studentcertificate = EStudentcertificate::getStudentcertificate(['and',[EStudentcertificate::tableName().'.iUserID' => $this->userid],[EStudentcertificate::tableName().'.status' => EStudentcertificate::PASSED]]);
        $studentcertificate = EStudentcertificate::getStudentcertificate();
        //获取证书类别
        $certificate = BCertificate::find()->orderBy('id desc')->all();
        foreach($studentcertificate as &$r)
        {
            //跳转到证书查询结果页
            $arPara = [
                'idcard'=>$r['idcard'],
                'sCertificateNum'=>$r['sCertificateNum'],
            ];

            $arStr = array();

            foreach ($arPara as $key => $v) {
                $arStr[] = $key . "=" . $v;
            }

            $url = implode('&',$arStr);
            $time = time();
            $signMsg = md5($url.'&time='.$time.'&salt='.md5(\Yii::$app->params['secretKey'].$time));

            $r['url'] = 'index.php?r=wap/site/certificateinfo&idcard='.base64_encode($arPara['idcard'].'@@'.\Yii::$app->params['secretKey']).'&sCertificateNum='.base64_encode($arPara['sCertificateNum'].'@@'.\Yii::$app->params['secretKey']).'&time='.$time.'&token='.$signMsg;
        }

        return $this->renderPartial('certificatelist',['cate'=>$studentcertificate,'certificate'=>$certificate]);
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

        return $this->renderPartial('article',['article'=>$article,'article2'=>$article2]);
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
//            $this->redirect(array('/wap/site/error'));
            header('location:index.php?r=wap/site/error');
        }else{
            $id = \Yii::$app->request->get('id');
            if(!is_numeric($id))
            {
                //跳转到错误页面
//                $this->redirect(array('/wap/site/error'));
                header('location:index.php?r=wap/site/error');
            }else{
                $article = BArticle::findOne($id);
                if(!$article)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/wap/site/error'));
                    header('location:index.php?r=wap/site/error');
                }else{
                    return $this->renderPartial('articleinfo',['article'=>$article]);
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
     * 全部课程
     */
    public function actionCourseindex()
    {
        if(\Yii::$app->request->isPost)
        {
            $sIndustryName = '全部';
            $post = \Yii::$app->request->post();
            if(!isset($post['tid']) || !is_numeric($post['tid']))
            {
                self::getFailInfo('请选择课程类别',$this->method);
            }

            if($post['tid'] > 0)
            {
                $course = BCourse::find()->andWhere(['and',['status'=>BCourse::PUBLISHED],['tid'=>$post['tid']]])->orderBy('id desc')->asArray()->all();
                //获取类别
                $sIndustryName = BIndustry::findOne($post['tid'])->sIndustryName;
            }else{
                $course = BCourse::find()->andWhere(['status'=>BCourse::PUBLISHED])->orderBy('id desc')->asArray()->all();
            }

            self::getSucInfo(['course'=>$course,'sIndustryName'=>$sIndustryName],$this->method);
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
//            $this->redirect(array('/wap/site/error'));
            header('location:index.php?r=wap/site/error');
        }else{
            $id = \Yii::$app->request->get('id');
            if(!is_numeric($id))
            {
                //跳转到错误页面
//                $this->redirect(array('/wap/site/error'));
                header('location:index.php?r=wap/site/error');
            }else{
                $course = BCourse::find()->where(['and',['id'=>$id],['status'=>BCourse::PUBLISHED]])->asArray()->one();
                if(!$course)
                {
                    //跳转到错误页面
//                    $this->redirect(array('/wap/site/error'));
                    header('location:index.php?r=wap/site/error');
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
