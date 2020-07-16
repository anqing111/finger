<?php

namespace app\modules\web\controllers;

use app\models\db\BArticle;
use app\models\db\BBanner;
use app\models\db\BCclive;
use app\models\db\BCertificate;
use app\models\db\BIndustry;
use app\models\db\BJoin;
use app\models\db\BMenu;
use app\models\db\BPerconf;
use app\models\db\BPosition;
use app\models\db\BPositiontype;
use app\models\db\BProblem;
use app\models\db\BSkill;
use app\models\db\BTrainingvideo;
use app\models\db\BUniversity;
use app\models\db\EInstructor;
use app\models\db\EInstructorbook;
use app\models\db\EInstructorvideo;
use app\models\db\BUserbaseinfo;
use app\models\db\BCourse;
use app\models\db\ELecturer;
use app\models\db\EOrgin;
use app\models\db\EStudentcertificate;
use app\models\db\EStudentprofile;
use app\models\RedactorForm;
use app\models\UploadForm;
use app\modules\web\model\process\IndustryProcess;
use app\modules\web\model\process\InstructorProcess;
use app\modules\web\model\process\PositionProcess;
use app\modules\web\model\process\PositionTypeProcess;
use yii\helpers\Json;
use yii\web\Controller;
/**
 * Default controller for the `web` module
 */
class AdminController extends BaseController
{
    public function actionIndex()
    {
        //获取菜单
        $menu = BMenu::getMenuList(['pid'=>\Yii::$app->session->get('pid')]);
        return $this->renderPartial('index',['menu'=>$menu]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 用户管理
     */
    public function actionUserindex()
    {
        /*
         * 获取所有用户
         * */
        $post = [];$andWhere = ['and'];

        if(\Yii::$app->request->isPost)
        {

            $post = \Yii::$app->request->post();
            if(!empty($post['sMail']))
            {
                $andWhere[] = ['=','sMail',$post['sMail']];
            }
            if(!empty($post['sPhone']))
            {
                $andWhere[] = ['=','sPhone',$post['sPhone']];
            }
        }

        $userBaseList = BUserbaseinfo::find()->andWhere($andWhere)->orderBy('iUserID desc')->all();

        return $this->renderPartial('userindex',['user'=>$userBaseList,'post'=>$post]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 用户管理-详情
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

        $userBaseInfo = BUserbaseinfo::findOne($iUserID);

        if(!$userBaseInfo)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        switch ($userBaseInfo->pid)
        {
            case BUserbaseinfo::STUDENT;
            {
                $userBaseInfo = BUserbaseinfo::getUserbaseinfo([BUserbaseinfo::tableName().'.iUserID' => $iUserID]);
                return $this->renderPartial('studentinfo');
            }
                break;
            case BUserbaseinfo::EXPERT;
            case BUserbaseinfo::LECTURER;
            {
                $userBaseInfo = ELecturer::find()->where(['iUserID' => $iUserID])->one();
                return $this->renderPartial('lecturerinfo',['lecturer'=>$userBaseInfo]);
            }
                break;
            default:
                return $this->renderPartial('userinfo');
                break;
        }

    }
    /*
     * 不通过原因
     * */
    public function actionAuthregect()
    {
        $params = [
            'lecturer'=>['url'=>'index.php?r=web/lecturer/lectureredit','status'=>ELecturer::OFFTHESHELF],
            'studentprofile'=>['url'=>'index.php?r=web/admin/studentprofileedit','status'=>EStudentprofile::FILED],
        ];

        if(empty(\Yii::$app->request->get('id')) || empty(\Yii::$app->request->get('param')) )
        {
            echo "参数错误";
            exit();
        }

        $get['id'] = \Yii::$app->request->get('id');
        if(!array_key_exists(\Yii::$app->request->get('param'),$params))
        {
            echo "参数错误";
            exit();
        }

        $get['param']['url'] = $params[\Yii::$app->request->get('param')]['url'];
        $get['param']['status'] = $params[\Yii::$app->request->get('param')]['status'];

        return $this->renderPartial('authregect',['get'=>$get]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 用户管理 - 编辑
     */
    public function actionUseredit()
    {
        /*
         * 获取所有用户
         * */
        $userBaseInfo = $orginL = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('用户名不得为空',$this->method);
            }

            $post['gid'] = $post['pid']; //默认所属角色和用户角色一致
            if(empty($post['sPassWord']))
            {
                unset($post['sPassWord']);
            }else{
                //密钥加密
                $post['sPassWord'] = base64_encode(\Yii::$app->getSecurity()->encryptByPassword($post['sPassWord'], \Yii::$app->params['secretKey']));
            }

            $post['dUpdateTime'] = date('Y-m-d H:i:s');

            if(\Yii::$app->request->post('iUserID'))
            {
                //编辑
                if(false == BUserbaseinfo::updateBaseUserInfo($post))
                {
                    self::getFailInfo('合作单位编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BUserbaseinfo::insertBaseUserInfo($post))
                {
                    self::getFailInfo('合作单位添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $iUserID = \Yii::$app->request->get('iUserID');
            if ($iUserID)
            {
                $userBaseInfo = BUserbaseinfo::findOne($iUserID);
                if(!$userBaseInfo)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
                //获取该角色下所有机构
                $orginL = EOrgin::find()->where(['pid'=>$userBaseInfo->pid])->orderBy('id desc')->all();
            }
        }
        //获取所有机构
        $orgin = EOrgin::find()->orderBy('id desc')->all();

        return $this->renderPartial('useredit',['user'=>$userBaseInfo,'orgin'=>$orgin,'orginL'=>$orginL]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 专家讲师-个人介绍 - 审核通过/不通过
     */
    public function actionLectureredit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('请输入审核不通过原因',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == ELecturer::updateLecturer($post))
                {
                    self::getFailInfo('个人介绍编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == ELecturer::insertLecturer($post))
                {
                    self::getFailInfo('个人介绍添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }

    }
    /**
     * Renders the index view for the module
     * @return string
     * 机构管理
     */
    public function actionOrginindex()
    {
        /*
         * 获取所有机构
         * */
        $post = $andWhere = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(!empty($post['sOrginName']))
            {
                $andWhere = ['like','sOrginName',$post['sOrginName']];
            }

        }

        $orgin = EOrgin::find()->andWhere($andWhere)->orderBy('id desc')->all();

        return $this->renderPartial('orginindex',['orgin'=>$orgin,'post'=>$post]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 机构管理 - 编辑
     */
    public function actionOrginedit()
    {
        $orgin = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('机构名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == EOrgin::updateOrgin($post))
                {
                    self::getFailInfo('机构编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == EOrgin::insertOrgin($post))
                {
                    self::getFailInfo('机构添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $orgin = EOrgin::findOne($id);
                if(!$orgin)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

        return $this->renderPartial('orginedit',['orgin'=>$orgin]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 课程管理
     */
    public function actionCourseindex()
    {
        /*
         * 获取所有课程
         * */
        $andWhere = ['and'];
        $post = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(!empty($post['sCourseName']))
            {
                $andWhere[] = ['like','sCourseName',$post['sCourseName']];
            }
            if(!empty($post['author']))
            {
                $andWhere[] = ['like','author',$post['author']];
            }
        }

        $course = BCourse::find()->andWhere($andWhere)->orderBy('id')->asArray()->all();

        return $this->renderPartial('courseindex',['course'=>$course,'post'=>$post]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 课程管理 - 编辑
     */
    public function actionCourseedit()
    {
        $course = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('课程名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                if(empty($post['status']))
                {
                    $one = BCourse::findOne(\Yii::$app->request->post('id'));
                    if($one->status == BCourse::PUBLISHED)
                    {
                        self::getFailInfo("课程已发布，请先下架在编辑",$this->method);
                    }
                }
                //编辑
                if(false == BCourse::updateCourse($post))
                {
                    self::getFailInfo('课程编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BCourse::insertCourse($post))
                {
                    self::getFailInfo('课程添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $course = BCourse::findOne($id);
                if(!$course)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        $model = new UploadForm();
        $dBeginTime = date('Y-m-d 23:59:59');

        return $this->renderPartial('courseedit',['course'=>$course,'dBeginTime'=>$dBeginTime,'model'=>$model]);

    }

    /**
     * Renders the index view for the module
     * @return string
     * 课程管理-详情
     */
    public function actionCourseinfo()
    {
        /*
         * 获取课程详情
         * */
        $id = \Yii::$app->request->get('id');
        if(!$id)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $course = BCourse::findOne($id);
        if(!$course)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        //获取培训视频
        $video = BTrainingvideo::find()->where(['cid' => $id])->all();

        return $this->renderPartial('courseinfo',['video'=>$video,'course'=>$course]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 课程管理 - 编辑视频
     */
    public function actionCoursevideoedit()
    {
        $video = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('章节名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                if(empty($post['status']))
                {
                    $one = BTrainingvideo::findOne(\Yii::$app->request->post('id'));
                    if($one->status == BTrainingvideo::PUBLISHED)
                    {
                        self::getFailInfo("课程视频已发布，请先下架在编辑",$this->method);
                    }
                }
                //编辑
                if(false == BTrainingvideo::updateCourseVideo($post))
                {
                    self::getFailInfo('视频课程编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BTrainingvideo::insertCourseVideo($post))
                {
                    self::getFailInfo('视频课程上传失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $video = BTrainingvideo::findOne($id);
                if(!$video)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

        if (empty(\Yii::$app->request->get('cid')))
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $cid = \Yii::$app->request->get('cid');

        $course = BCourse::findOne($cid);
        if(!$course)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        return $this->renderPartial('coursevideoedit',['video'=>$video,'course'=>$course]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 审核管理-学员档案信息审核
     */
    public function actionStudentprofileindex()
    {
        /*
         * 获取所有学员档案信息
         * */
        $profile = EStudentprofile::find()->orderBy('id')->all();

        return $this->renderPartial('studentprofileindex',['profile'=>$profile]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 审核管理-学员档案信息管理 - 审核状态
     */
    public function actionStudentprofileedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post) || empty($post['id']))
            {
                self::getFailInfo('请输入审核不通过原因',$this->method);
            }
            //获取学员档案详情
            $profile = EStudentprofile::findOne($post['id']);

            $transaction = EStudentprofile::getDb()->beginTransaction();
            try {

                $id = EStudentprofile::updateStudentprofile($post);
                //编辑
                if(!$id)
                {
                    self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                }

                //上传证书
                if(!empty($post['add']))
                {
                    $cate = BCertificate::findOne($post['cid']);
                    $params = [
                        'iUserID' => $profile->iUserID,
                        'cid' => $post['cid'],
                        'subjectName' => $cate['subjectName'],
                        'idcard' => $profile->idcard,
                        'sName' => $post['sName'],
                        'sContent' => $post['sContent'],
                        'sCertificateNum' => $post['sCertificateNum'],
                        'sCertificateImg' => $post['sCertificateImg'],
                        'dGetDate' => $post['dGetDate'],
                        'sOrginName' => $profile->sOrginName,
                        'status' => EStudentcertificate::UNDERREVIEW
                    ];

                    $id = EStudentcertificate::insertStudentcertificate($params);
                    if(!$id)
                    {
                        self::getFailInfo('学员档案信息管理编辑失败',$this->method);
                    }
                }

                if(!empty($post['edit']))
                {
                    //获取当前证书
                    $cate = EStudentcertificate::find()->where(['and','idcard'=>$profile->idcard,'sCertificateNum'=>$profile->sCertificateNum])->one();
                    $params = [
                        'id' => $cate->id,
                        'cid' => $post['cid'],
                        'sName' => $post['sName'],
                        'sContent' => $post['sContent'],
                        'sCertificateNum' => $post['sCertificateNum'],
                        'sCertificateImg' => $post['sCertificateImg'],
                        'dGetDate' => $post['dGetDate']
                    ];
                    $id = EStudentcertificate::updateStudentcertificate($params);
                    if(!$id)
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
        }

        $id = \Yii::$app->request->get('id');
        if(!$id)
        {
            self::getFailInfo('参数错误',$this->method);
        }
        $profile = EStudentprofile::getStudentprofile([EStudentprofile::tableName().'.id' => $id]);

        //获取证书类别
        $cate = BCertificate::find()->all();
        $dBeginTime = date('Y-m-d');
        return $this->renderPartial('studentprofileedit',['profile'=>$profile,'cate'=>$cate,'dBeginTime'=>$dBeginTime]);
    }
    /*
     * 审核管理-学员档案信息详情
     * */
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

        return $this->render('studentprofileinfo');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 审核管理-学员录入证书审核
     */
    public function actionStudentcertificateindex()
    {
        /*
         * 获取所有证书
         * */
        if(\Yii::$app->request->isPost)
        {
            $andWhere = ['and'];

            if(\Yii::$app->request->post('name'))
            {
                $andWhere[] = ['like','name',\Yii::$app->request->post('name')];
            }
            if(\Yii::$app->request->post('cid'))
            {
                $andWhere[] = ['cid' => \Yii::$app->request->post('cid')];
            }
            if(\Yii::$app->request->post('status'))
            {
                $andWhere[] = ['status' => \Yii::$app->request->post('status')];
            }

            $studentcertificate = EStudentcertificate::getStudentcertificate($andWhere);

        }else{
            $studentcertificate = EStudentcertificate::getStudentcertificate(['1' => 1]);
        }

        //获取所有类别
        $cate = BCertificate::find()->orderBy('id desc')->all();

        return $this->render('studentcertificateindex');
    }
    /**
     * Renders the index view for the module
     * @return string
     * 审核管理-学员录入证书详情
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
     * 审核管理 - 学员录入证书编辑-审核通过/不通过
     */
    public function actionStudentcertificateedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('请输入审核不通过原因',$this->method);
            }

            //编辑
            if(false == EStudentcertificate::updateStudentcertificate($post))
            {
                self::getFailInfo('证书编辑失败',$this->method);
            }

            self::getSucInfo(['ok'=>true],$this->method);
        }

    }
    /**
     * Renders the index view for the module
     * @return string
     * 审核管理-申请加盟审核
     */
    public function actionJoinindex()
    {
        /*
         * 获取申请加盟
         * */
        if(\Yii::$app->request->isPost)
        {
            $andWhere = ['and'];

            if(\Yii::$app->request->post('person'))
            {
                $andWhere[] = ['like','person',\Yii::$app->request->post('person')];
            }
            if(\Yii::$app->request->post('status'))
            {
                $andWhere[] = ['status' => \Yii::$app->request->post('status')];
            }

            $join = BJoin::find()->andWhere($andWhere)->orderBy('id desc ')->all();

        }else{
            $join = BJoin::find()->orderBy('id desc ')->all();
        }

        return $this->render('joinindex');
    }
    /**
     * Renders the index view for the module
     * @return string
     * 审核管理-申请加盟详情
     */
    public function actionJoininfo()
    {
        /*
         * 获取证书详情
         * */
        $id = \Yii::$app->request->get('id');
        if(!$id)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $join = BJoin::findOne($id);

        if(!$join)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        return $this->render('joininfo');

    }
    /**
     * Renders the index view for the module
     * @return string
     * 审核管理 - 申请加盟-审核通过/不通过
     */
    public function actionJoinedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('请输入审核不通过原因',$this->method);
            }

            //编辑
            if(false == BJoin::updateJoin($post))
            {
                self::getFailInfo('申请加盟编辑失败',$this->method);
            }

            self::getSucInfo(['ok'=>true],$this->method);
        }

    }
    /**
     * Renders the index view for the module
     * @return string
     * 证书类别管理
     */
    public function actionCertindex()
    {
        /*
         * 获取所有证书类别
         * */
        $post = $where = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(!empty($post['subjectName']))
            {
                $where = ['like','subjectName',$post['subjectName']];
            }
        }
        $cert = BCertificate::find()->andWhere($where)->orderBy('id')->all();

        return $this->renderPartial('certindex',['cert'=>$cert,'post'=>$post]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 证书类别管理 - 编辑
     */
    public function actionCertedit()
    {
        $cert = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('所属类别不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == BCertificate::updateCert($post))
                {
                    self::getFailInfo('证书类别编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BCertificate::insertCert($post))
                {
                    self::getFailInfo('证书类别添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $cert = BCertificate::findOne($id);
                if(!$cert)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

        return $this->renderPartial('certedit',['cert'=>$cert]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 讲师秀
     */
    public function actionInstructorindex()
    {
        /*
         * 获取所有讲师秀
         * */
        $post = $where = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(!empty($post['sName']))
            {
                $where = ['like','sName',$post['sName']];
            }
        }
        $instructor = EInstructor::find()->andWhere($where)->orderBy('id')->asArray()->all();

        return $this->renderPartial('instructorindex',['instructor'=>$instructor,'post'=>$post]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 讲师秀管理 - 编辑
     */
    public function actionInstructoredit()
    {
        $instructor = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('姓名不得为空',$this->method);
            }
            $transaction = EInstructor::getDb()->beginTransaction();
            try {
                //如果传入是json就转换一下
                $book = $post['book'];
                if(!is_array($book))
                {
                    $book = Json::decode($post['book']);
                }

                $video = $post['video'];
                if(!is_array($video))
                {
                    $video = Json::decode($post['video']);
                }

                if(\Yii::$app->request->post('id'))
                {
                    //编辑
                    $id = EInstructor::updateInstructor($post);
                    if(!$id)
                    {
                        self::getFailInfo('讲师秀编辑失败，请重新上传',$this->method);
                    }

                    if(false == InstructorProcess::editbook($id,$book))
                    {
                        self::getFailInfo('讲师秀编辑失败，请重新上传',$this->method);
                    }

                    if(false == InstructorProcess::editvideo($id,$video))
                    {
                        self::getFailInfo('讲师秀编辑失败，请重新上传',$this->method);
                    }

                }else{
                    //添加
                    $id = EInstructor::insertInstructor($post);
                    if(!$id)
                    {
                        self::getFailInfo('讲师秀添加失败，请重新上传',$this->method);
                    }

                    if(false == InstructorProcess::addbook($id,$book))
                    {
                        self::getFailInfo('讲师秀添加失败，请重新上传1',$this->method);
                    }

                    if(false == InstructorProcess::addvideo($id,$video))
                    {
                        self::getFailInfo('讲师秀添加失败，请重新上传2',$this->method);
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
                $instructor = EInstructor::getInstructor([EInstructor::tableName().'.id'=>$id]);
                if(!$instructor)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        $model = new UploadForm();
        return $this->renderPartial('instructoredit',['instructor'=>$instructor,'model'=>$model]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 文章管理
     */
    public function actionArticleindex()
    {
        /*
         * 获取所有文章
         * */
        $andWhere = ['and'];
        $post = [];
        $type = 0;
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(!empty($post['title']))
            {
                $andWhere[] = ['like','title',$post['title']];
            }

            if(!empty($post['status']))
            {
                $andWhere[] = ['=','status',$post['status']];
            }

            if(!empty($post['type']))
            {
                $type = $post['type'];
                $andWhere[] = ['=','type',$post['type']];
            }

        }

        $article = BArticle::find()->andWhere($andWhere)->orderBy('id')->all();

        return $this->renderPartial('articleindex',['article'=>$article,'post'=>$post,'type'=>$type]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 文章管理 - 编辑
     */
    public function actionArticleedit()
    {
        $article = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('标题不得为空',$this->method);
            }

            if(!empty($post['status']) && $post['status'] == BArticle::PUBLISHED)
            {
                $post['dReleaseTime'] = date('Y-m-d H:i:s');
            }

            $msg = '技能薪酬排行榜文章';

            if($post['type'] == BArticle::INFORMATION_TYPE)
            {
                $msg = '网站资讯文章';
            }

            if(!empty($post['RedactorForm']['content']))
            {
                $post['content'] = $post['RedactorForm']['content'];
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑，先判断一下状态
                if(empty($post['status']))
                {
                    $one = BArticle::findOne(\Yii::$app->request->post('id'));
                    if($one->status == BArticle::PUBLISHED)
                    {
                        self::getFailInfo("文章已发布，请先下架在编辑",$this->method);
                    }
                }
                if(false == BArticle::updateArticle($post))
                {
                    self::getFailInfo("{$msg}编辑失败",$this->method);
                }
            }else{
                $post['dReleaseTime'] = date('Y-m-d H:i:s');
                //添加
                if(false == BArticle::insertArticle($post))
                {
                    self::getFailInfo("{$msg}添加失败",$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $article = BArticle::findOne($id);
                if(!$article)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        $model = new UploadForm();
        $redactor = new RedactorForm();
        return $this->renderPartial('articleedit',['article'=>$article,'model'=>$model,'redactor'=>$redactor]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * banner管理
     */
    public function actionBannerindex()
    {
        /*
         * 获取所有banner
         * */
        $banner = BBanner::find()->orderBy('id')->all();

        return $this->renderPartial('bannerindex',['banner'=>$banner]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * banner管理 - 编辑
     */
    public function actionBanneredit()
    {
        $banner = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('标题不得为空',$this->method);
            }

            if(!empty($post['aid']))
            {
                $article = BArticle::findOne($post['aid']);
                if($article)
                {
                    $post['url'] = 'index.php?r=web/site/article&id='.$article->id;
                }
            }

            if(\Yii::$app->request->post('id'))
            {
                if(empty($post['status']))
                {
                    $one = BBanner::findOne(\Yii::$app->request->post('id'));
                    if($one->status == BUniversity::PUBLISHED)
                    {
                        self::getFailInfo("banner已发布，请先下架在编辑",$this->method);
                    }
                }
                //编辑
                if(false == BBanner::updateBanner($post))
                {
                    self::getFailInfo('banner编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BBanner::insertBanner($post))
                {
                    self::getFailInfo('banner添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);
        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $banner = BBanner::findOne($id);
                if(!$banner)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        $model = new UploadForm();
        $dBeginTime = date('Y-m-d 23:59:59');
        //获取文章列表
        $article = BArticle::find()->andWhere(['status'=>BArticle::PUBLISHED])->orderBy('id')->all();
        return $this->renderPartial('banneredit',['banner'=>$banner,'dBeginTime'=>$dBeginTime,'model'=>$model,'article'=>$article]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 校企合作
     */
    public function actionUniversityindex()
    {
        /*
         * 获取所有校企合作信息
         * */
        $university = BUniversity::find()->orderBy('id')->all();

        return $this->renderPartial('universityindex',['university'=>$university]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 校企合作 - 编辑
     */
    public function actionUniversityedit()
    {
        $university = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('标题不得为空',$this->method);
            }

            if(!empty($post['RedactorForm']['content']))
            {
                $post['content'] = $post['RedactorForm']['content'];
            }

            if(!empty($post['status']) && $post['status'] == BUniversity::PUBLISHED)
            {
                $post['dReleaseTime'] = date('Y-m-d H:i:s');
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(empty($post['status']))
                {
                    $one = BUniversity::findOne(\Yii::$app->request->post('id'));
                    if($one->status == BUniversity::PUBLISHED)
                    {
                        self::getFailInfo("校企合作已发布，请先下架在编辑",$this->method);
                    }
                }
                if(false == BUniversity::updateUniversity($post))
                {
                    self::getFailInfo('校企合作编辑失败',$this->method);
                }
            }else{
                //添加
                $post['dReleaseTime'] = date('Y-m-d H:i:s');
                if(false == BUniversity::insertUniversity($post))
                {
                    self::getFailInfo('校企合作添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $university = BUniversity::findOne($id);
                if(!$university)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        $model = new UploadForm();
        $redactor = new RedactorForm();
        return $this->renderPartial('universityedit',['university'=>$university,'model'=>$model,'redactor'=>$redactor]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 题目管理
     */
    public function actionProblemindex()
    {
        /*
         * 获取所有机构上传视频选择问题
         * */
        $problem = BProblem::find()->orderBy('id')->all();

        return $this->renderPartial('problemindex',['problem'=>$problem]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 题目管理 - 编辑
     */
    public function actionProblemedit()
    {
        $problem = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('题目不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == BProblem::updateProblem($post))
                {
                    self::getFailInfo('题目编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BProblem::insertProblem($post))
                {
                    self::getFailInfo('题目添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $problem = BProblem::findOne($id);
                if(!$problem)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        //获取所有行业
        $industr = BIndustry::find()->where(['>','industryID','0'])->orderBy('id desc ')->all();

        return $this->renderPartial('problemedit',['problem'=>$problem,'industr'=>$industr]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-行业类别显示
     */
    public function actionIndustryindex()
    {
        /*
         * 获取所有行业类别
         * */
        $industr = BIndustry::getIndustry([BIndustry::tableName().'.industryID' => 0]);
        return $this->renderPartial('industryindex',['industr'=>$industr]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-行业类别编辑
     */
    public function actionIndustryedit()
    {
        $industr = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('行业名称不得为空',$this->method);
            }
            $transaction = BIndustry::getDb()->beginTransaction();
            try {
                //如果传入是json就转换一下
                $child = $post['child'];
                if(!is_array($child))
                {
                    $child = Json::decode($post['child']);
                }

                if(\Yii::$app->request->post('id'))
                {
                    $id = BIndustry::updateIndustry($post);
                    if(!$id)
                    {
                        self::getFailInfo('行业类别编辑失败',$this->method);
                    }

                    //编辑
                    if(false == IndustryProcess::editchildindustry($id,$child))
                    {
                        self::getFailInfo('行业类别编辑失败',$this->method);
                    }
                }else{
                    //添加
                    $id = BIndustry::insertIndustry($post);
                    if(!$id)
                    {
                        self::getFailInfo('行业类别添加失败',$this->method);
                    }

                    if(false == IndustryProcess::addchildindustry($id,$child))
                    {
                        self::getFailInfo('行业类别添加失败',$this->method);
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
                $industr = BIndustry::getIndustry([BIndustry::tableName().'.id' => $id]);

                if(!$industr)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        return $this->renderPartial('industryedit',['industr'=>$industr]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-技能标签管理
     */
    public function actionSkillindex()
    {
        /*
         * 获取所有技能标签
         * */
        $skill = BSkill::find()->orderBy('id')->all();

        return $this->render('skillindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-技能标签管理-编辑
     */
    public function actionSkilledit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('技能标签名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == BSkill::updateSkill($post))
                {
                    self::getFailInfo('技能标签名称编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == BSkill::insertSkill($post))
                {
                    self::getFailInfo('技能标签名称添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $skill = BSkill::findOne($id);
                if(!$skill)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

    }
    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-期望职位显示
     */
    public function actionPositionindex()
    {
        /*
         * 获取所有职位类别
         * */
        $positionr = BPosition::getPosition([BPosition::tableName().'.iPositionID' => 0]);

        print_r($positionr);

//        return $this->render('industryindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-期望职位编辑
     */
    public function actionPositionedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('期望职位名称不得为空',$this->method);
            }
            $transaction = BPosition::getDb()->beginTransaction();
            try {
                //如果传入是json就转换一下
                $child = $post['child'];
                if(!is_array($child))
                {
                    $child = Json::decode($post['child']);
                }

                if(\Yii::$app->request->post('id'))
                {
                    $id = BPosition::updatePosition($post);
                    if(!$id)
                    {
                        self::getFailInfo('期望职位编辑失败',$this->method);
                    }

                    //编辑
                    if(false == PositionProcess::editchildposition($id,$child))
                    {
                        self::getFailInfo('期望职位编辑失败',$this->method);
                    }
                }else{
                    //添加
                    $id = BPosition::insertPosition($post);
                    if(!$id)
                    {
                        self::getFailInfo('期望职位添加失败',$this->method);
                    }

                    if(false == PositionProcess::addchildposition($id,$child))
                    {
                        self::getFailInfo('期望职位添加失败',$this->method);
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
                $position = BPosition::getPosition([BPosition::tableName().'.id' => $id]);

                if(!$position)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

    }
    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-职位类别显示
     */
    public function actionPositiontypeindex()
    {
        /*
         * 获取所有职位类别
         * */
        $positionr = BPositiontype::getPositionType([BPositiontype::tableName().'.iPositionID' => 0]);

        print_r($positionr);

//        return $this->render('industryindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-职位类别编辑
     */
    public function actionPositiontypeedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('职位类别名称不得为空',$this->method);
            }
            $transaction = BPositiontype::getDb()->beginTransaction();
            try {
                //如果传入是json就转换一下
                $child = $post['child'];
                if(!is_array($child))
                {
                    $child = Json::decode($post['child']);
                }

                if(\Yii::$app->request->post('id'))
                {
                    $id = BPositiontype::updatePositionType($post);
                    if(!$id)
                    {
                        self::getFailInfo('职位类别编辑失败',$this->method);
                    }

                    //编辑
                    if(false == PositionTypeProcess::editchildpositiontype($id,$child))
                    {
                        self::getFailInfo('职位类别编辑失败2',$this->method);
                    }
                }else{
                    //添加
                    $id = BPositiontype::insertPositionType($post);
                    if(!$id)
                    {
                        self::getFailInfo('职位类别添加失败',$this->method);
                    }

                    if(false == PositionTypeProcess::addchildpositiontype($id,$child))
                    {
                        self::getFailInfo('职位类别添加失败',$this->method);
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
                $position = BPositiontype::getPositionType([BPositiontype::tableName().'.id' => $id]);

                if(!$position)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

    }
    /**
     * Renders the index view for the module
     * @return string
     * 直播管理-直播列表显示
     */
    public function actionLiveindex()
    {
        $cclive = BCclive::find()->orderBy('cid desc')->all();
        return $this->renderPartial('liveindex',['cclive'=>$cclive]);
    }

    /**
     * Renders the index view for the module
     * @return string
     * 直播管理-直播列表编辑
     */
    public function actionLiveinfo()
    {
        if (empty(\Yii::$app->request->get('cid')))
        {
            self::getFailInfo('参数错误',$this->method);
        }

        $id = \Yii::$app->request->get('cid');

        $cclive = BCclive::find()->where(['cid'=>$id])->one();

        if(!$cclive)
        {
            self::getFailInfo('参数错误',$this->method);
        }

        return $this->renderPartial('liveinfo',['cclive'=>$cclive]);
    }
}
