<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_course}}".
 *
 * @property int $id 自增id
 * @property string $sCourseName 课程名称
 * @property string $sCourseImg 课程图片
 * @property string $sCourseInfo 课程简介
 * @property string $author 作者
 * @property int $classhour 课时
 * @property int $type 课程分类
 * @property string $dRecordingTime 录制时间
 * @property int $status 状态
 * @property string $dCreatTime 创建时间
 */
class BCourse extends \yii\db\ActiveRecord
{
    /*
     * 课程分类
     * 1 证书课程 2 继续教育课程
     * */
    const CERTIFICATE = 1;
    const EDUCATION = 2;
    public static $_type = [
        self::CERTIFICATE => '证书课程',
        self::EDUCATION => '继续教育课程',
    ];
    /*
    * banner-状态
    * 1-未发布
    * 2-已发布
    * 3-已下架
    * */
    const UNRELEASED = 1;
    const PUBLISHED = 2;
    const OFFTHESHELF = 3;
    public static $_status = [
        self::UNRELEASED => '未发布',
        self::PUBLISHED => '已发布',
        self::OFFTHESHELF => '已下架',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_course}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['classhour', 'type', 'status'], 'integer'],
            [['dRecordingTime', 'dCreatTime'], 'safe'],
            [['sCourseName'], 'string', 'max' => 100],
            [['sCourseImg', 'sCourseInfo'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'sCourseName' => Yii::t('app', '课程名称'),
            'sCourseImg' => Yii::t('app', '课程图片'),
            'sCourseInfo' => Yii::t('app', '课程简介'),
            'author' => Yii::t('app', '作者'),
            'classhour' => Yii::t('app', '课时'),
            'type' => Yii::t('app', '课程分类'),
            'dRecordingTime' => Yii::t('app', '录制时间'),
            'status' => Yii::t('app', '状态'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BCourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BCourseQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertCourse($params)
    {
        $post = new BCourse();
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

    public static function updateCourse($params)
    {
        //新增项目
        $obj = new BCourse();
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
