<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_studentcertificate}}".
 *
 * @property int $id 自增id
 * @property int $iUserID 学员id
 * @property int $cid 所属类别id
 * @property string $idcard 身份证号
 * @property string $sName 证书名称
 * @property string $sContent 文字简介
 * @property string $sCertificateNum 证书编号
 * @property string $sCertificateImg 上传证书
 * @property string $dGetDate 获得时间
 * @property string $sOrganName 所属机构
 * @property int $status 状态
 * @property string $cause 审核不通过原因
 * @property string $dCreatTime 创建时间
 */
class EStudentcertificate extends \yii\db\ActiveRecord
{
    /*
     * 审核状态
     * 审核中 1 已通过 2 未通过 3
     * */
    const UNDERREVIEW = 1;
    const PASSED = 2;
    const FILED = 3;

    public static $_status = [
        self::UNDERREVIEW => '审核中',
        self::PASSED => '已通过',
        self::FILED => '未通过',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_studentcertificate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iUserID', 'cid', 'status'], 'integer'],
            [['dGetDate', 'dCreatTime'], 'safe'],
            [['idcard'], 'string', 'max' => 18],
            [['sName', 'sOrganName'], 'string', 'max' => 100],
            [['sContent', 'sCertificateImg', 'cause'], 'string', 'max' => 255],
            [['sCertificateNum'], 'string', 'max' => 50],
            [['idcard'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'iUserID' => Yii::t('app', '学员id'),
            'cid' => Yii::t('app', '所属类别id'),
            'idcard' => Yii::t('app', '身份证号'),
            'sName' => Yii::t('app', '证书名称'),
            'sContent' => Yii::t('app', '文字简介'),
            'sCertificateNum' => Yii::t('app', '证书编号'),
            'sCertificateImg' => Yii::t('app', '上传证书'),
            'dGetDate' => Yii::t('app', '获得时间'),
            'sOrganName' => Yii::t('app', '所属机构'),
            'status' => Yii::t('app', '状态'),
            'cause' => Yii::t('app', '审核不通过原因'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EStudentcertificateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EStudentcertificateQuery(get_called_class());
    }

    //获取该学员所有证书
    public static function getStudentcertificate($params = [])
    {
        //查询生成器查询
        $query = (new \yii\db\Query());
        $industr = $query->from(self::tableName())
            ->select([self::tableName().'.id','sName','sCertificateNum','subjectName','dGetDate','status','sOrganName','cause','sNick','c.iUserID','sCertificateImg'])
            ->leftJoin(['b' => BCertificate::tableName()], self::tableName().'.cid = b.id')
            ->leftJoin(['c' => BUserbaseinfo::tableName()], self::tableName().'.iUserID = c.iUserID')
            ->where($params)
            ->orderBy(self::tableName().'.id desc')
            ->all();

        return $industr;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertStudentcertificate($params)
    {
        $post = new EStudentcertificate();
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

    public static function updateStudentcertificate($params)
    {
        //新增项目
        $obj = new EStudentcertificate();
        //过滤无效字段（将数据表中未定义的字段去除）
        $params = self::filterInputFields($params,$obj->attributeLabels());

        $post = $obj::find()->where(['id' => $params['id']])->one();

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
