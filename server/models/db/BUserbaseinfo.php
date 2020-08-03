<?php

namespace app\models\db;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%b_userbaseinfo}}".
 *
 * @property int $iUserID 用户id
 * @property string $sPhone 手机号
 * @property string $sMail 邮箱
 * @property string $sPassWord 密码
 * @property string $idcard 身份证号
 * @property int $pid 用户角色
 * @property int $gid 所属角色
 * @property int $oid 所属机构
 * @property string $sNick 用户名
 * @property float $iCurPrice 用户当前余额
 * @property float $iTotalPrice 用户总余额
 * @property int $userStatus 用户状态
 * @property int $iUserSourceID 用户来源
 * @property string $unionid 微信unionid
 * @property string $xcxopenid 微信小程序openid
 * @property int $userLevel 用户级别
 * @property string $dVIPBeginTime 用户VIP开始时间
 * @property string $dVIPEndTime 用户VIP结束时间
 * @property string $dUpdateTime 用户更新时间
 * @property string $dCreatTime 创建时间
 */
class BUserbaseinfo extends \yii\db\ActiveRecord
{
    /*
     * 用户状态
     * 正常用户 1 禁用用户 2
     * */
    const NORMAL = 1;
    const DISABLE = 2;
    /*
     * 用户角色
     * 1-学员 2-管理员 3-专家 4-讲师 5-机构 6-企业 7-院校
     * */
    const STUDENT = 1;
    const ADMIN = 2;
    const EXPERT = 3;
    const LECTURER = 4;
    const ORGIN = 5;
    const BUSINESS = 6;
    const COLLEGES = 7;
    public static $_preconf = [
        self::STUDENT => '学员',
        self::ADMIN => '管理员',
        self::EXPERT => '专家',
        self::LECTURER => '讲师',
        self::ORGIN => '机构',
        self::BUSINESS => '企业',
        self::COLLEGES => '院校',
    ];
    /*
     * 用户等级
     * 1-普通用户 2-中间用户
     * */
    const COMMON = 1;
    const MIDDLE = 2;
    public static $_userLevel = [
        self::COMMON => '普通用户',
        self::MIDDLE => '中间用户'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_userbaseinfo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'gid', 'oid', 'userStatus', 'iUserSourceID', 'userLevel'], 'integer'],
            [['iCurPrice', 'iTotalPrice'], 'number'],
            [['dVIPBeginTime', 'dVIPEndTime', 'dUpdateTime', 'dCreatTime'], 'safe'],
            [['sPhone'], 'string', 'max' => 11],
            [['sMail'], 'string', 'max' => 40],
            [['sPassWord'], 'string', 'max' => 255],
            [['idcard'], 'string', 'max' => 18],
            [['sNick'], 'string', 'max' => 30],
            [['unionid', 'xcxopenid'], 'string', 'max' => 64],
            [['sPhone'], 'unique'],
            [['idcard'], 'unique'],
            [['sMail'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iUserID' => Yii::t('app', '用户id'),
            'sPhone' => Yii::t('app', '手机号'),
            'sMail' => Yii::t('app', '邮箱'),
            'sPassWord' => Yii::t('app', '密码'),
            'idcard' => Yii::t('app', '身份证号'),
            'pid' => Yii::t('app', '用户角色'),
            'gid' => Yii::t('app', '所属角色'),
            'oid' => Yii::t('app', '所属机构'),
            'sNick' => Yii::t('app', '用户名'),
            'iCurPrice' => Yii::t('app', '用户当前余额'),
            'iTotalPrice' => Yii::t('app', '用户总余额'),
            'userStatus' => Yii::t('app', '用户状态'),
            'iUserSourceID' => Yii::t('app', '用户来源'),
            'unionid' => Yii::t('app', '微信unionid'),
            'xcxopenid' => Yii::t('app', '微信小程序openid'),
            'userLevel' => Yii::t('app', '用户级别'),
            'dVIPBeginTime' => Yii::t('app', '用户VIP开始时间'),
            'dVIPEndTime' => Yii::t('app', '用户VIP结束时间'),
            'dUpdateTime' => Yii::t('app', '用户更新时间'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BUserbaseinfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BUserbaseinfoQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    //获取学员档案作品秀
    public function getStudentopus()
    {
        $studentopus = $this->hasMany(EStudentopus::className(),['iUserID' => 'iUserID'])->asArray();
        return $studentopus;
    }

    //获取学员档案培训视频
    public function getTrainingvideo()
    {
        $trainingvideo = $this->hasMany(ETrainingvideo::className(),['iUserID' => 'iUserID'])->asArray();
        return $trainingvideo;
    }

    //获取学员档案答辩视频
    public function getDefensevideo()
    {
        $defensevideo = $this->hasMany(EDefensevideo::className(),['iUserID' => 'iUserID'])->asArray();
        return $defensevideo;
    }

    //获取学员档案实操视频
    public function getPracticevideo()
    {
        $practicevideo = $this->hasMany(EPracticevideo::className(),['iUserID' => 'iUserID'])->asArray();
        return $practicevideo;
    }

    //获取学员证书信息
    public function getStudentcertificate()
    {
        $studentcertificate = $this->hasMany(EStudentcertificate::className(),['iUserID' => 'iUserID'])->asArray();
        return $studentcertificate;
    }

    //获取学员学习视频
    public function getVideo()
    {
        $video = $this->hasMany(BVideo::className(),['iUserID' => 'iUserID'])->asArray();
        return $video;
    }

    //获取学员档案信息
    public function getStudentprofile()
    {
        $studentprofile = $this->hasOne(EStudentprofile::className(),['iUserID' => 'iUserID'])->asArray();
        return $studentprofile;
    }

    public static function getUserbaseinfo($params)
    {
        //AR创建关联查询，查询的结果是2个sql语句拼接的结果，并不是sql语句的联合查询
        $profile = self::find()
            ->joinWith([
                'studentopus b'=>function(Query $query){
                    $query->select([
                        'b.sContent',
                        'b.sOpusvideoUrl',
                        'b.iUserID',
                    ]);
                },
                'trainingvideo c'=>function(Query $query){
                    $query->select([
                        'c.sChapterName',
                        'c.sTrainingvideoUrl',
                        'c.author',
                        'c.time',
                        'c.iUserID',
                    ]);
                },
                'defensevideo d'=>function(Query $query){
                    $query->select([
                        'd.sProblemName',
                        'd.sDefensevideoUrl',
                        'd.author',
                        'd.time',
                        'd.iUserID',
                    ]);
                },
                'practicevideo e'=>function(Query $query){
                    $query->select([
                        'e.sProblemName',
                        'e.sPracticevideoUrl',
                        'e.author',
                        'e.time',
                        'e.iUserID',
                    ]);
                },
                'studentcertificate f'=>function(Query $query){
                    $query->select([
                        'f.id',
                        'f.sName',
                        'f.sContent',
                        'f.sCertificateNum',
                        'f.sCertificateImg',
                        'f.sOrganName',
                        'f.dGetDate',
                        'f.iUserID',
                    ]);
                },
                'video g'=>function(Query $query){
                    $query->select([
                        'g.sProblemName',
                        'g.sVideoUrl',
                        'g.id',
                        'g.iUserID',
                    ]);
                },
                'studentprofile h'=>function(Query $query){
                    $query->select([
                        'h.sInstructorEndorsementImg',
                        'h.sStudentEndorsementImg',
                        'h.sClassNotesImg',
                        'h.iUserID',
                    ]);
                }
            ])->where($params)->asArray()->one();

        return $profile;
    }

    public static function getUserbaselist($params)
    {
        //查询生成器查询
        $query = (new \yii\db\Query());
        $industr = $query->from(self::tableName())
            ->select(['b.iUserID','b.sNick','b.sMail','b.sPhone'])
            ->leftJoin(['b' => self::tableName()], self::tableName().'.oid = b.oid')
            ->where($params)
            ->orderBy('b.iUserID desc')
            ->all();

        return $industr;
    }

    public static function insertBaseUserInfo($params)
    {
        $post = new BUserbaseinfo();
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

    public static function updateBaseUserInfo($params)
    {
        //新增项目
        $obj = new BUserbaseinfo();
        //过滤无效字段（将数据表中未定义的字段去除）
        $params = self::filterInputFields($params,$obj->attributeLabels());

        $post = $obj::findOne($params['iUserID']);

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
        return $params['iUserID'];
    }
}
