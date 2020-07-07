<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_banner}}".
 *
 * @property int $id 自增id
 * @property string $name 名称
 * @property string $image 图片
 * @property string $url 路径
 * @property int $status 状态
 * @property int $iClientsID 终端类型
 * @property string $date_from 开始日期
 * @property string $date_to 结束日期
 * @property string $dCreatTime 创建时间
 */
class BBanner extends \yii\db\ActiveRecord
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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_banner}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image', 'url'], 'required'],
            [['status', 'iClientsID'], 'integer'],
            [['date_from', 'date_to', 'dCreatTime'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['image', 'url'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'name' => Yii::t('app', '名称'),
            'image' => Yii::t('app', '图片'),
            'url' => Yii::t('app', '路径'),
            'status' => Yii::t('app', '状态'),
            'iClientsID' => Yii::t('app', '终端类型'),
            'date_from' => Yii::t('app', '开始日期'),
            'date_to' => Yii::t('app', '结束日期'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BBannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BBannerQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertBanner($params)
    {
        $post = new BBanner();
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

    public static function updateBanner($params)
    {
        //新增项目
        $obj = new BBanner();
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
