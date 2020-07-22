<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_instructorvideo}}".
 *
 * @property int $id 自增id
 * @property int $tid 讲师秀id
 * @property string $sTrainUrl 讲课视频
 * @property string $sTrainImg 背景图片
 * @property string $sOpusInfo 作品介绍
 * @property string $dCreatTime 创建时间
 */
class EInstructorvideo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_instructorvideo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tid'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sTrainUrl', 'sOpusInfo'], 'string', 'max' => 255],
            [['sTrainImg'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'tid' => Yii::t('app', '讲师秀id'),
            'sTrainUrl' => Yii::t('app', '讲课视频'),
            'sTrainImg' => Yii::t('app', '背景图片'),
            'sOpusInfo' => Yii::t('app', '作品介绍'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EInstructorvideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EInstructorvideoQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function updateEInstructorvideo($params)
    {
        //新增项目
        $obj = new EInstructorvideo();
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

    public static function insertInstructorVideo($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.EInstructorvideo::tableName().'',
            ['sTrainUrl','sOpusInfo','sTrainImg','tid'],//字段
            $params
        )->execute();

        return $flag;
    }
}
