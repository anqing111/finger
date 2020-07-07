<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_defensevideo}}".
 *
 * @property int $id 自增id
 * @property int $pid 答辩视频问题自增id
 * @property int $sid 学员档案信息自增id
 * @property int $iUserID 学员id
 * @property string $sProblemName 问题
 * @property string $sDefensevideoUrl 答辩视频
 * @property string $author 作者
 * @property string $time 时长
 * @property string $dCreatTime 创建时间
 */
class EDefensevideo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_defensevideo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'sid', 'iUserID'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sProblemName'], 'string', 'max' => 100],
            [['sDefensevideoUrl'], 'string', 'max' => 255],
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
            'pid' => Yii::t('app', '答辩视频问题自增id'),
            'sid' => Yii::t('app', '学员档案信息自增id'),
            'iUserID' => Yii::t('app', '学员id'),
            'sProblemName' => Yii::t('app', '问题'),
            'sDefensevideoUrl' => Yii::t('app', '答辩视频'),
            'author' => Yii::t('app', '作者'),
            'time' => Yii::t('app', '时长'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EDefensevideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EDefensevideoQuery(get_called_class());
    }

    public static function batchInsertDefensevideo($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.EDefensevideo::tableName().'',
            ['pid','sid','iUserID','sProblemName','sDefensevideoUrl','author','time'],//字段
            $params
        )->execute();

        return $flag;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function updateDefensevideo($params)
    {
        //新增项目
        $obj = new EDefensevideo();
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
