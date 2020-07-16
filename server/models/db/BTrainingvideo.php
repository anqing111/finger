<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_trainingvideo}}".
 *
 * @property int $id 自增id
 * @property int $cid 课程id
 * @property string $sChapterName 章节名称
 * @property string $sTrainingvideoUrl 培训试听视频
 * @property string $author 作者
 * @property string $time 时长
 * @property int $status 状态
 * @property string $dCreatTime 创建时间
 */
class BTrainingvideo extends \yii\db\ActiveRecord
{
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
        return '{{%b_trainingvideo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid', 'status'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sChapterName'], 'string', 'max' => 100],
            [['sTrainingvideoUrl'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 50],
            [['time'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'cid' => Yii::t('app', '课程id'),
            'sChapterName' => Yii::t('app', '章节名称'),
            'sTrainingvideoUrl' => Yii::t('app', '培训试听视频'),
            'author' => Yii::t('app', '作者'),
            'time' => Yii::t('app', '时长'),
            'status' => Yii::t('app', '状态'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BTrainingvideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BTrainingvideoQuery(get_called_class());
    }
    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertCourseVideo($params)
    {
        $post = new BTrainingvideo();
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

    public static function updateCourseVideo($params)
    {
        //新增项目
        $obj = new BTrainingvideo();
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
