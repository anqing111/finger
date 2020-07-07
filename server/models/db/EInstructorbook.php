<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_instructorbook}}".
 *
 * @property int $id 自增id
 * @property int $tid 讲师秀id
 * @property string $sBookName 书名
 * @property string $sBookImg 书图片
 * @property string $dCreatTime 创建时间
 */
class EInstructorbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_instructorbook}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tid'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sBookName'], 'string', 'max' => 50],
            [['sBookImg'], 'string', 'max' => 100],
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
            'sBookName' => Yii::t('app', '书名'),
            'sBookImg' => Yii::t('app', '书图片'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EInstructorbookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EInstructorbookQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function updateEInstructorbook($params)
    {
        //新增项目
        $obj = new EInstructorbook();
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

    public static function insertInstructorBook($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.EInstructorbook::tableName().'',
            ['sBookName','sBookImg','tid'],//字段
            $params
        )->execute();

        return $flag;
    }
}
