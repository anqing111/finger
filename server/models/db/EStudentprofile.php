<?php

namespace app\models\db;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%e_studentprofile}}".
 *
 * @property int $id 自增id
 * @property int $iEntID 企业或机构下用户id
 * @property int $iUserID 学员id
 * @property string $name 姓名
 * @property string $idcard 身份证号
 * @property string $sMail 邮箱
 * @property string $sPhone 手机号
 * @property string $sOrginName 机构名称
 * @property string $sInstructorEndorsementImg 辅导员背书
 * @property string $sStudentEndorsementImg 同学背书
 * @property string $sClassNotesImg 课堂笔记
 * @property int $status 状态
 * @property int $cid 所属类别id
 * @property string $subjectName 所属类别
 * @property string $sName 证书名称
 * @property string $sCertificateNum 证书编号
 * @property string $sCertificateImg 上传证书
 * @property string $dGetDate 获得时间
 * @property string $sContent 文字简介
 * @property string $post_by 快递公司名称
 * @property string $post_no 快递单号
 * @property string $cause 审核不通过原因
 * @property string $dCreatTime 创建时间
 */
class EStudentprofile extends \yii\db\ActiveRecord
{
    /*
     * 审核状态
     * 审核中 1 审核通过-制证状态 2 审核通过-证书已发出 3 已通过 4 未通过 5
     * */
    const UNDERREVIEW = 1;
    const PASSEDREADY = 2;
    const PASSEDSEND = 3;
    const PASSED = 4;
    const FILED = 5;

    public static $_status = [
        self::UNDERREVIEW => '审核中',
        self::PASSEDREADY => '审核通过-制证状态',
        self::PASSEDSEND => '审核通过-证书已发出',
        self::PASSED => '已通过',
        self::FILED => '未通过',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_studentprofile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iEntID', 'iUserID', 'status', 'cid'], 'integer'],
            [['dGetDate', 'dCreatTime'], 'safe'],
            [['name', 'post_by', 'post_no'], 'string', 'max' => 20],
            [['idcard'], 'string', 'max' => 18],
            [['sMail'], 'string', 'max' => 40],
            [['sPhone'], 'string', 'max' => 11],
            [['sOrginName', 'sName'], 'string', 'max' => 100],
            [['sInstructorEndorsementImg', 'sStudentEndorsementImg', 'sClassNotesImg', 'sCertificateImg', 'sContent', 'cause'], 'string', 'max' => 255],
            [['subjectName', 'sCertificateNum'], 'string', 'max' => 50],
            [['iEntID', 'iUserID'], 'unique', 'targetAttribute' => ['iEntID', 'iUserID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'iEntID' => Yii::t('app', '企业或机构下用户id'),
            'iUserID' => Yii::t('app', '学员id'),
            'name' => Yii::t('app', '姓名'),
            'idcard' => Yii::t('app', '身份证号'),
            'sMail' => Yii::t('app', '邮箱'),
            'sPhone' => Yii::t('app', '手机号'),
            'sOrginName' => Yii::t('app', '机构名称'),
            'sInstructorEndorsementImg' => Yii::t('app', '辅导员背书'),
            'sStudentEndorsementImg' => Yii::t('app', '同学背书'),
            'sClassNotesImg' => Yii::t('app', '课堂笔记'),
            'status' => Yii::t('app', '状态'),
            'cid' => Yii::t('app', '所属类别id'),
            'subjectName' => Yii::t('app', '所属类别'),
            'sName' => Yii::t('app', '证书名称'),
            'sCertificateNum' => Yii::t('app', '证书编号'),
            'sCertificateImg' => Yii::t('app', '上传证书'),
            'dGetDate' => Yii::t('app', '获得时间'),
            'sContent' => Yii::t('app', '文字简介'),
            'post_by' => Yii::t('app', '快递公司名称'),
            'post_no' => Yii::t('app', '快递单号'),
            'cause' => Yii::t('app', '审核不通过原因'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EStudentprofileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EStudentprofileQuery(get_called_class());
    }

    //获取学员档案作品秀
    public function getStudentopus()
    {
        $studentopus = $this->hasMany(EStudentopus::className(),['iStuID' => 'id'])->asArray();
        return $studentopus;
    }

    //获取学员档案培训视频
    public function getTrainingvideo()
    {
        $trainingvideo = $this->hasMany(ETrainingvideo::className(),['sid' => 'id'])->asArray();
        return $trainingvideo;
    }

    //获取学员档案答辩视频
    public function getDefensevideo()
    {
        $defensevideo = $this->hasMany(EDefensevideo::className(),['sid' => 'id'])->asArray();
        return $defensevideo;
    }

    //获取学员档案实操视频
    public function getPracticevideo()
    {
        $practicevideo = $this->hasMany(EPracticevideo::className(),['sid' => 'id'])->asArray();
        return $practicevideo;
    }

    public static function getStudentprofile($params)
    {
        //AR创建关联查询，查询的结果是2个sql语句拼接的结果，并不是sql语句的联合查询
        $profile = self::find()
            ->joinWith([
                'studentopus b'=>function(Query $query){
                    $query->select([
                        'b.sContent',
                        'b.sOpusvideoUrl',
                        'b.sOpusvideoImg',
                        'b.iStuID'
                    ]);
                },
                'trainingvideo c'=>function(Query $query){
                    $query->select([
                        'c.sChapterName',
                        'c.sTrainingvideoUrl',
                        'c.author',
                        'c.time',
                        'c.sid',
                        'c.cid',
                        'c.bid'
                    ]);
                },
                'defensevideo d'=>function(Query $query){
                    $query->select([
                        'd.sProblemName',
                        'd.sDefensevideoUrl',
                        'd.author',
                        'd.time',
                        'd.sid',
                        'd.pid'
                    ]);
                },
                'practicevideo e'=>function(Query $query){
                    $query->select([
                        'e.sProblemName',
                        'e.sPracticevideoUrl',
                        'e.author',
                        'e.time',
                        'e.sid',
                        'e.pid'
                    ]);
                }
            ])->where($params)->asArray()->one();

        return $profile;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertStudentprofile($params)
    {
        $post = new EStudentprofile();
        //过滤无效字段（将数据表中未定义的字段去除）
        $params = self::filterInputFields($params,$post->attributeLabels());
        //新增项目
        reset($params);

        for($i=0; $i<count($params); $i++)
        {
            $nField = current($params);
            $key = key($params);
            $post->$key = $nField;
            next($params);
        }
        if(!$post->validate() or !$post->save())
        {
            return FALSE;
        }
        return $post->primaryKey;
    }

    public static function updateStudentprofile($params)
    {
        //新增项目
        $obj = new EStudentprofile();
        //过滤无效字段（将数据表中未定义的字段去除）
        $params = self::filterInputFields($params,$obj->attributeLabels());

        $post = $obj::findOne($params['id']);

        reset($params);

        for($i=0; $i<count($params); $i++)
        {
            $nField = current($params);
            $key = key($params);
            $post->$key = $nField;
            next($params);
        }
        if(!$post->validate() or !$post->save())
        {
            return FALSE;
        }
        return $params['id'];
    }
}
