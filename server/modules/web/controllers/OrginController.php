<?php

namespace app\modules\web\controllers;

use app\models\db\BCourse;
use app\models\db\BProblem;
use app\models\db\BTrainingvideo;
use app\models\db\BUserbaseinfo;
use app\models\db\EOrgin;
use app\models\db\EStudentprofile;
use app\models\RedactorForm;
use app\models\UploadForm;
use app\modules\web\model\process\StudentprofileProcess;
use yii\helpers\Json;
use yii\web\Controller;
/**
 * Default controller for the `web` module
 */
class OrginController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     * 学员管理
     */
    public function actionUserindex()
    {
        /*
         * 获取该机构下所有学员
         * */
        $user = BUserbaseinfo::getUserbaselist([BUserbaseinfo::tableName().'.iUserID' => $this->userid,'b.pid'=>BUserbaseinfo::STUDENT]);

        return $this->renderPartial('studentindex',['user'=>$user]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 学员管理-详情
     */
    public function actionUserinfo()
    {
        /*
         * 获取用户详情
         * */
        $iUserID = \Yii::$app->request->get('iUserID');
        if(!$iUserID)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $userBaseInfo = BUserbaseinfo::getUserbaseinfo([BUserbaseinfo::tableName().'.iUserID' => $iUserID]);

        if(!$userBaseInfo)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        return $this->render('studentinfo');
    }
    /**
     * Renders the index view for the module
     * @return string
     * 学员管理 - 编辑
     */
    public function actionUseredit()
    {
        $user = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('姓名不得为空',$this->method);
            }

            $post['sPassWord'] = rand(100000,999999);
            //密钥加密
            $post['sPassWord'] = base64_encode(\Yii::$app->getSecurity()->encryptByPassword($post['sPassWord'], \Yii::$app->params['secretKey']));

            $post['dUpdateTime'] = date('Y-m-d H:i:s');

            if(\Yii::$app->request->post('iUserID'))
            {
                //编辑
                if(false == BUserbaseinfo::updateBaseUserInfo($post))
                {
                    self::getFailInfo('学员管理编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BUserbaseinfo::insertBaseUserInfo($post))
                {
                    self::getFailInfo('学员管理添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $iUserID = \Yii::$app->request->get('iUserID');
            if ($iUserID)
            {
                $user = BUserbaseinfo::findOne($iUserID);
                if(!$user)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

        $baseinfo = BUserbaseinfo::findOne($this->userid);
        return $this->renderPartial('studentedit',['user'=>$user,'baseinfo'=>$baseinfo]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 学员档案信息管理
     */
    public function actionStudentprofileindex()
    {
        /*
         * 获取该机构下所有学员档案信息
         * */
        $profile = EStudentprofile::find()->where('iEntID =:iEntID ',[':iEntID'=>$this->userid])->orderBy('id')->all();
        return $this->renderPartial('studentprofileindex',['profile'=>$profile]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 学员档案信息管理-详情
     */
    public function actionStudentprofileinfo()
    {
        /*
         * 学员档案信息详情
         * */
        $id = \Yii::$app->request->get('id');
        if(!$id)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $profile = EStudentprofile::getStudentprofile([EStudentprofile::tableName().'.id' => $id]);

        return $this->renderPartial('studentprofileinfo',['profile'=>$profile]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 学员档案信息管理 - 编辑
     */
    public function actionStudentprofileedit()
    {
        $profile = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post) || empty($post['iUserID']))
            {
                self::getFailInfo('姓名不得为空',$this->method);
            }

            //获取学员基本信息
            $userbaseinfo = BUserbaseinfo::findOne($post['iUserID']);
            if(!$userbaseinfo)
            {
                self::getFailInfo('该学员不存在，请核实',$this->method);
            }

            $post['name'] = $userbaseinfo->sNick;
            $post['idcard'] = $userbaseinfo->idcard;
            $post['sMail'] = $userbaseinfo->sMail;
            $post['sPhone'] = $userbaseinfo->sPhone;
            $post['status'] = EStudentprofile::UNDERREVIEW;

            //获取所属机构名称
            $orgin = EOrgin::getOrginByUser(['iUserID' => $this->userid]);
            $post['sOrginName'] = $orgin['sOrginName'];
            $post['iEntID'] = $this->userid;

            $transaction = EStudentprofile::getDb()->beginTransaction();
            try {

                if(\Yii::$app->request->post('id'))
                {
                    $id = EStudentprofile::updateStudentprofile($post);
                    //编辑
                    if(!$id)
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                    //编辑作品秀
                    if(false == StudentprofileProcess::editchildstudentopus($id,$post['studentopus']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                    //编辑培训视频
                    if(false == StudentprofileProcess::editchildtrainingvideo($id,$post['trainingvideo']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                    //编辑实操视频
                    if(false == StudentprofileProcess::editchildpracticevideo($id,$post['practicevideo']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                    //编辑答辩视频
                    if(false == StudentprofileProcess::editchilddefensevideo($id,$post['defensevideo']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                }else{
                    //添加
                    $id = EStudentprofile::insertStudentprofile($post);
                    if(!$id)
                    {
                        self::getFailInfo('学员档案信息管理添加失败',$this->method);
                    }
                    //添加作品秀
                    if(false == StudentprofileProcess::addchildstudentopus($id,$post['iUserID'],$post['studentopus']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                    //添加培训视频
                    if(false == StudentprofileProcess::addchildtrainingvideo($id,$post['iUserID'],$post['trainingvideo']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                    //添加实操视频
                    if(false == StudentprofileProcess::addchildpracticevideo($id,$post['iUserID'],$post['practicevideo']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                    //添加答辩视频
                    if(false == StudentprofileProcess::addchilddefensevideo($id,$post['iUserID'],$post['defensevideo']))
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                }

                $transaction->commit();
            } catch(\Exception $e) {
                $transaction->rollBack();
                self::getFailInfo($e->getMessage(),$this->method);
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $profile = EStudentprofile::getStudentprofile([EStudentprofile::tableName().'.id'=>$id]);
                if(!$profile)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        $model = new UploadForm();
        //获取该机构下学员信息
        $user = BUserbaseinfo::getUserbaselist([BUserbaseinfo::tableName().'.iUserID' => $this->userid,'b.pid'=>BUserbaseinfo::STUDENT]);
        //获取所有培训课程及所有章节目录
        $course = BCourse::find()->where(['type'=>BCourse::CERTIFICATE])->orderBy('id desc')->all();
        $video = BTrainingvideo::find()->asArray()->all();
        //获取所有题目
        $problem = BProblem::find()->all();
        return $this->renderPartial('studentprofileedit',[
            'profile'=>$profile,
            'model'=>$model,
            'user'=>$user,
            'course'=>$course,
            'video'=>$video,
            'problem'=>$problem
        ]);
    }

}
