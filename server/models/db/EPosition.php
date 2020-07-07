<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_position}}".
 *
 * @property int $id 自增id
 * @property string $sPositionName 职位名称
 * @property int $iPositionID 父职位id
 * @property string $dCreatTime 创建时间
 */
class EPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_position}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iPositionID'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sPositionName'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'sPositionName' => Yii::t('app', '职位名称'),
            'iPositionID' => Yii::t('app', '父职位id'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EPositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EPositionQuery(get_called_class());
    }

    public static function batchInsertPosition($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.EPosition::tableName().'',
            ['sPositionName','iPositionID'],//字段
            $params
        )->execute();

        return $flag;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertPosition($params)
    {
        $post = new EPosition();
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

    public static function updatePosition($params)
    {
        //新增项目
        $obj = new EPosition();
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
