<?php

namespace app\models\db;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%b_course}}".
 *
 * @property int $id 自增id
 * @property string $sCourseName 课程名称
 * @property string $sCourseImg 课程图片
 * @property string $sCourseInfo 课程简介
 * @property string $author 作者
 * @property string $headportrait 头像
 * @property string $info 讲师简介
 * @property int $classhour 课时
 * @property int $type 课程分类
 * @property string $dRecordingTime 录制时间
 * @property int $tid 行业类型
 * @property string $sIndustryName 行业名称
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
            [['classhour', 'type', 'tid', 'status'], 'integer'],
            [['dRecordingTime', 'dCreatTime'], 'safe'],
            [['sCourseName', 'headportrait'], 'string', 'max' => 100],
            [['sCourseImg', 'sCourseInfo', 'info'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 50],
            [['sIndustryName'], 'string', 'max' => 30],
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
            'headportrait' => Yii::t('app', '头像'),
            'info' => Yii::t('app', '讲师简介'),
            'classhour' => Yii::t('app', '课时'),
            'type' => Yii::t('app', '课程分类'),
            'dRecordingTime' => Yii::t('app', '录制时间'),
            'tid' => Yii::t('app', '行业类型'),
            'sIndustryName' => Yii::t('app', '行业名称'),
            'status' => Yii::t('app', '状态'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    //获取课程章节
    public function getTrainingvideo()
    {
        $video = $this->hasMany(BTrainingvideo::className(),['cid' => 'id'])->asArray();
        return $video;
    }

    public static function getCourseinfo($params)
    {
        //AR创建关联查询，查询的结果是2个sql语句拼接的结果，并不是sql语句的联合查询
        $profile = self::find()
            ->joinWith([
                'trainingvideo b'=>function(Query $query){
                    $query->select([
                        'b.cid',
                        'b.sChapterName',
                        'b.sTrainingvideoUrl',
                        'b.time',
                    ])->where(['b.status'=>BTrainingvideo::PUBLISHED]);
                }
            ])->where($params)->asArray()->all();

        return $profile;
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
