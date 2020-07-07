<?php

namespace app\modules\web\controllers;

use app\models\db\BArticle;
use app\models\db\BBanner;
use app\models\db\BCertificate;
use app\models\db\BIndustry;
use app\models\db\BJoin;
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
use app\modules\web\model\process\IndustryProcess;
use app\modules\web\model\process\InstructorProcess;
use app\modules\web\model\process\PositionProcess;
use app\modules\web\model\process\PositionTypeProcess;
use MongoDB\BSON\Binary;
use yii\helpers\Json;
use yii\web\Controller;
/**
 * Default controller for the `web` module
 */
class AdminController extends BaseController
{
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
        $userBaseList = BUserbaseinfo::find()->orderBy('iUserID')->all();
        return $this->render('userindex');
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
                return $this->render('studentinfo');
            }
                break;
            case BUserbaseinfo::EXPERT;
            case BUserbaseinfo::LECTURER;
            {
                $userBaseInfo = ELecturer::find()->where(['iUserID =:iUserID'],[':iUseriD'=>$iUserID])->one();
                return $this->render('lecturerinfo');
            }
                break;
            default:
                return $this->render('userinfo');
                break;
        }

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
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('用户名不得为空',$this->method);
            }

            $post['gid'] = $post['pid']; //默认所属角色和用户角色一致

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
            }
        }

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
        $andWhere = [];
        if(\Yii::$app->request->isPost)
        {
            if(\Yii::$app->request->post('sOrginName'))
            {
                $andWhere = ['like','sOrginName',\Yii::$app->request->post('sOrginName')];
            }

        }

        $orgin = EOrgin::getOrgin($andWhere);

        return $this->render('orginindex');
    }
    /**
     * Renders the index view for the module
     * @return string
     * 机构管理 - 编辑
     */
    public function actionOrginedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('机构名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('iUserID'))
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
        if(\Yii::$app->request->isPost)
        {
            $andWhere = ['and'];

            if(\Yii::$app->request->post('sCourseName'))
            {
                $andWhere[] = ['like','sCourseName',\Yii::$app->request->post('sCourseName')];
            }
            if(\Yii::$app->request->post('author'))
            {
                $andWhere[] = ['like','author',\Yii::$app->request->post('author')];
            }

            $course = BCourse::find()->andWhere($andWhere)->orderBy('id')->asArray()->all();

        }else{
            $course = BCourse::find()->orderBy('id')->asArray()->all();
        }

//        return $this->render('courseindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 课程管理 - 编辑
     */
    public function actionCourseedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('课程名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
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

        return $this->render('courseinfo');
    }
    /**
     * Renders the index view for the module
     * @return string
     * 课程管理 - 编辑视频
     */
    public function actionCourseVideoedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('章节名称不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
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
        if(\Yii::$app->request->isPost)
        {
            $andWhere = ['and'];

            if(\Yii::$app->request->post('name'))
            {
                $andWhere[] = ['like','name',\Yii::$app->request->post('name')];
            }
            if(\Yii::$app->request->post('sPhone'))
            {
                $andWhere[] = ['sPhone' => \Yii::$app->request->post('sPhone')];
            }
            if(\Yii::$app->request->post('status'))
            {
                $andWhere[] = ['status' => \Yii::$app->request->post('status')];
            }

            $profile = EStudentprofile::find()->andWhere($andWhere)->orderBy('id')->all();

        }else{
            $profile = EStudentprofile::find()->orderBy('id')->all();
        }
        print_r($profile);

//        return $this->render('studentprofileindex');
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
                    $params = [
                        'iUserID' => $profile->iUserID,
                        'cid' => $post['cid'],
                        'idcard' => $profile->idcard,
                        'sName' => $post['sName'],
                        'sContent' => $post['sContent'],
                        'sCertificateNum' => $post['sCertificateNum'],
                        'sCertificateImg' => $post['sCertificateImg'],
                        'dGetDate' => $post['dGetDate'],
                        'sOrganName' => $profile->sOrganName,
                        'status' => EStudentcertificate::PASSED
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
        if(\Yii::$app->request->isPost)
        {
            $where = [];

            if(\Yii::$app->request->post('subjectName'))
            {
                $where = ['like','subjectName',\Yii::$app->request->post('subjectName')];
            }

            $cert = BCourse::find()->andWhere($where)->asArray()->orderBy('id')->all();

        }else{
            $cert = BCertificate::find()->orderBy('id')->asArray()->all();
        }

        return $this->render('certindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 证书类别管理 - 编辑
     */
    public function actionCertedit()
    {
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
                $course = BCertificate::findOne($id);
                if(!$course)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

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
        if(\Yii::$app->request->isPost)
        {
            $where = [];

            if(\Yii::$app->request->post('sName'))
            {
                $where = ['like','sName',\Yii::$app->request->post('sName')];
            }

            $course = EInstructor::find()->andWhere($where)->orderBy('id')->asArray()->all();

        }else{
            $instructor = EInstructor::find()->orderBy('id')->asArray()->all();
        }

        return $this->render('instructorindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 讲师秀管理 - 编辑
     */
    public function actionInstructoredit()
    {
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
                        self::getFailInfo('讲师秀添加失败，请重新上传',$this->method);
                    }

                    if(false == InstructorProcess::addvideo($id,$video))
                    {
                        self::getFailInfo('讲师秀添加失败，请重新上传',$this->method);
                    }

                }
                $transaction->commit();
            } catch(\Exception $e) {
                $transaction->rollBack();
                self::getFailInfo('讲师秀添加失败，请重新上传',$this->method);
            }

            self::getSucInfo(['ok'=>true],$this->method);
        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $course = EInstructor::findOne($id);
                if(!$course)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
                //获取所有著作
                $instructorbook = EInstructorbook::find()->where(['tid' => $id])->all();
                //获取所有视频
                $instructorvideo = EInstructorvideo::find()->where(['tid' => $id])->all();
            }
        }

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
        if(\Yii::$app->request->isPost)
        {
            $andWhere = ['and'];

            $type = \Yii::$app->request->post('type');

            if(\Yii::$app->request->post('title'))
            {
                $andWhere[] = ['like','title',\Yii::$app->request->post('title')];
            }

            $andWhere[] = ['type'=>$type];

            $article = BArticle::find()->andWhere($andWhere)->asArray()->orderBy('id')->all();

        }else{

            $type = \Yii::$app->request->post('type');

            $article = BArticle::find()->where(['type'=>$type])->orderBy('id')->asArray()->all();
        }

        if($type == BArticle::INFORMATION_TYPE)
        {
            return $this->render('articleindex');
        }

        return $this->render('articleindex_skill');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 文章管理 - 编辑
     */
    public function actionArticleedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('标题不得为空',$this->method);
            }

            $post['dReleaseTime'] = date('Y-m-d H:i:s');

            $msg = '技能薪酬排行榜文章';

            if($post['type'] == BArticle::INFORMATION_TYPE)
            {
                $msg = '网站资讯文章';
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == BArticle::updateArticle($post))
                {
                    self::getFailInfo("{$msg}编辑失败",$this->method);
                }
            }else{
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

        return $this->render('bannerindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * banner管理 - 编辑
     */
    public function actionBanneredit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('标题不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
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

        return $this->render('universityindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 校企合作 - 编辑
     */
    public function actionUniversityedit()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(empty($post))
            {
                self::getFailInfo('标题不得为空',$this->method);
            }

            $post['dReleaseTime'] = date('Y-m-d H:i:s');

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(false == BUniversity::updateUniversity($post))
                {
                    self::getFailInfo('校企合作编辑失败',$this->method);
                }
            }else{
                //添加
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
                $banner = BUniversity::findOne($id);
                if(!$banner)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

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

        return $this->render('problemindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 题目管理 - 编辑
     */
    public function actionProblemedit()
    {
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

        print_r($industr);

//        return $this->render('industryindex');
    }

    /**
     * Renders the index view for the module
     * @return string
     * 专业管理-行业类别编辑
     */
    public function actionIndustryedit()
    {
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
                $industr = BIndustry::getIndustry(['and',BIndustry::tableName().'.id' => $id,BIndustry::tableName().'.industryID' => 0]);

                if(!$industr)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

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
                $position = BPosition::getPosition(['and',BPosition::tableName().'.id' => $id,BPosition::tableName().'.iPositionID' => 0]);

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
                $position = BPositiontype::getPositionType(['and',BPositiontype::tableName().'.id' => $id,BPositiontype::tableName().'.iPositionID' => 0]);

                if(!$position)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }

    }
}
