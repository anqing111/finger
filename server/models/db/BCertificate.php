<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_certificate}}".
 *
 * @property int $id 自增id
 * @property string $subjectName 所属类别
 * @property string $dCreatTime 创建时间
 */
class BCertificate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_certificate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dCreatTime'], 'safe'],
            [['subjectName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'subjectName' => Yii::t('app', '所属类别'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BCertificateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BCertificateQuery(get_called_class());
    }
    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertCert($params)
    {
        $post = new BCertificate();
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

    public static function updateCert($params)
    {
        //新增项目
        $obj = new BCertificate();
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
