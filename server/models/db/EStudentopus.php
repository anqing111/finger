<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_studentopus}}".
 *
 * @property int $id 自增id
 * @property int $iStuID 档案id
 * @property int $iResumeID 简历id
 * @property int $iUserID 学员id
 * @property string $sContent 文字简介
 * @property string $sOpusvideoUrl 学生作品视频
 * @property string $sOpusvideoImg 背景图
 * @property int $isRec 是否推荐到首页
 * @property string $dCreatTime 创建时间
 */
class EStudentopus extends \yii\db\ActiveRecord
{
    /*
   * 是否推荐到首页
   * 1 是 0 否
   * */
    const YES = 1;
    const NO = 0;
    public static $_isRec = [
        self::YES => '是',
        self::NO => '否',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_studentopus}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iStuID', 'iResumeID', 'iUserID', 'isRec'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sContent', 'sOpusvideoUrl', 'sOpusvideoImg'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'iStuID' => Yii::t('app', '档案id'),
            'iResumeID' => Yii::t('app', '简历id'),
            'iUserID' => Yii::t('app', '学员id'),
            'sContent' => Yii::t('app', '文字简介'),
            'sOpusvideoUrl' => Yii::t('app', '学生作品视频'),
            'sOpusvideoImg' => Yii::t('app', '背景图'),
            'isRec' => Yii::t('app', '是否推荐到首页'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EStudentopusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EStudentopusQuery(get_called_class());
    }

    public static function getStudentopuslist()
    {
        //查询生成器查询
        $query = (new \yii\db\Query());
        $industr = $query->from(self::tableName())
            ->select(['id','sContent','isRec','sNick'])
            ->leftJoin(['b' => BUserbaseinfo::tableName()], self::tableName().'.iUserID = b.iUserID')
            ->orderBy('id desc')
            ->all();

        return $industr;
    }

    public static function batchInsertStudentopus($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.EStudentopus::tableName().'',
            ['iStuID','iResumeID','iUserID','sContent','sOpusvideoUrl','sOpusvideoImg'],//字段
            $params
        )->execute();

        return $flag;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function updateStudentpus($params)
    {
        //新增项目
        $obj = new EStudentopus();
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
