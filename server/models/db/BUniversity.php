<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_university}}".
 *
 * @property int $id 自增id
 * @property string $title 标题
 * @property string $img 图片
 * @property string|null $content 内容
 * @property int $status 状态
 * @property string $dReleaseTime 发布时间
 * @property string $dCreatTime 创建时间
 */
class BUniversity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_university}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['status'], 'integer'],
            [['dReleaseTime', 'dCreatTime'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'title' => Yii::t('app', '标题'),
            'img' => Yii::t('app', '图片'),
            'content' => Yii::t('app', '内容'),
            'status' => Yii::t('app', '状态'),
            'dReleaseTime' => Yii::t('app', '发布时间'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BUniversityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BUniversityQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertUniversity($params)
    {
        $post = new BUniversity();
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

    public static function updateUniversity($params)
    {
        //新增项目
        $obj = new BUniversity();
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
