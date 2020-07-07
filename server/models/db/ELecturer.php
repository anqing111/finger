<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_lecturer}}".
 *
 * @property int $id 自增id
 * @property int $iUserID 用户ID
 * @property string $sName 姓名
 * @property int $sex 性别
 * @property string|null $info 个人简介
 * @property string $certificate 证书
 * @property string $headportrait 头像
 * @property int $status 状态
 * @property string $cause 审核不通过原因
 * @property string $dCreatTime 创建时间
 */
class ELecturer extends \yii\db\ActiveRecord
{
    /*
    * 专家/讲师个人介绍审核-状态
    * 1-未发布
    * 2-已发布
    * 3-已下架
    * */
    const UNRELEASED = 1;
    const PUBLISHED = 2;
    const OFFTHESHELF = 3;

    /*
     * 性别
     * */
    const MAN = 1;
    const WOMAN = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_lecturer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iUserID', 'sex', 'status'], 'integer'],
            [['info'], 'string'],
            [['dCreatTime'], 'safe'],
            [['sName'], 'string', 'max' => 20],
            [['certificate', 'headportrait'], 'string', 'max' => 100],
            [['cause'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'iUserID' => Yii::t('app', '用户ID'),
            'sName' => Yii::t('app', '姓名'),
            'sex' => Yii::t('app', '性别'),
            'info' => Yii::t('app', '个人简介'),
            'certificate' => Yii::t('app', '证书'),
            'headportrait' => Yii::t('app', '头像'),
            'status' => Yii::t('app', '状态'),
            'cause' => Yii::t('app', '审核不通过原因'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ELecturerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ELecturerQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertLecturer($params)
    {
        $post = new ELecturer();
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

    public static function updateLecturer($params)
    {
        //新增项目
        $obj = new ELecturer();
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
