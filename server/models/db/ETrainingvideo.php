<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_trainingvideo}}".
 *
 * @property int $id 自增id
 * @property int $cid 课程id
 * @property int $bid 培训视频章节自增id
 * @property int $sid 学员档案信息自增id
 * @property int $iUserID 学员id
 * @property string $sChapterName 章节名称
 * @property string $sTrainingvideoUrl 培训视频
 * @property string $author 作者
 * @property string $time 时长
 * @property string $dCreatTime 创建时间
 */
class ETrainingvideo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_trainingvideo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid', 'bid', 'sid', 'iUserID'], 'integer'],
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
            'bid' => Yii::t('app', '培训视频章节自增id'),
            'sid' => Yii::t('app', '学员档案信息自增id'),
            'iUserID' => Yii::t('app', '学员id'),
            'sChapterName' => Yii::t('app', '章节名称'),
            'sTrainingvideoUrl' => Yii::t('app', '培训视频'),
            'author' => Yii::t('app', '作者'),
            'time' => Yii::t('app', '时长'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ETrainingvideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ETrainingvideoQuery(get_called_class());
    }

    public static function batchInsertTrainingvideo($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.ETrainingvideo::tableName().'',
            ['cid','bid','sid','iUserID','sChapterName','sTrainingvideoUrl','author','time'],//字段
            $params
        )->execute();

        return $flag;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function updateTrainingvideo($params)
    {
        //新增项目
        $obj = new ETrainingvideo();
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
