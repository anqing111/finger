<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_join}}".
 *
 * @property int $id 自增id
 * @property int $iJoinNum 加盟编号
 * @property string $sUnitName 单位名称
 * @property string $person 负责人
 * @property string $sPhone 手机号
 * @property string $direction 加盟方向
 * @property string $sMail 邮箱
 * @property string $sPassWord 默认密码
 * @property int $iCityID 城市ID
 * @property string $sCityName 城市名称
 * @property int $status 状态
 * @property string $cause 审核不通过原因
 * @property string $dCreatTime 创建时间
 */
class BJoin extends \yii\db\ActiveRecord
{
    /*
     * 审核状态
     * 审核中 1 已通过 2 未通过 3
     * */
    const UNDERREVIEW = 1;
    const PASSED = 2;
    const FILED = 3;

    public static $_status = [
        self::UNDERREVIEW => '审核中',
        self::PASSED => '已通过',
        self::FILED => '未通过',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_join}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iJoinNum', 'iCityID', 'status'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sUnitName', 'direction'], 'string', 'max' => 100],
            [['person'], 'string', 'max' => 50],
            [['sPhone'], 'string', 'max' => 11],
            [['sMail'], 'string', 'max' => 40],
            [['sPassWord'], 'string', 'max' => 16],
            [['sCityName'], 'string', 'max' => 20],
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
            'iJoinNum' => Yii::t('app', '加盟编号'),
            'sUnitName' => Yii::t('app', '单位名称'),
            'person' => Yii::t('app', '负责人'),
            'sPhone' => Yii::t('app', '手机号'),
            'direction' => Yii::t('app', '加盟方向'),
            'sMail' => Yii::t('app', '邮箱'),
            'sPassWord' => Yii::t('app', '默认密码'),
            'iCityID' => Yii::t('app', '城市ID'),
            'sCityName' => Yii::t('app', '城市名称'),
            'status' => Yii::t('app', '状态'),
            'cause' => Yii::t('app', '审核不通过原因'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BJoinQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BJoinQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertJoin($params)
    {
        $post = new BJoin();
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

    public static function updateJoin($params)
    {
        //新增项目
        $obj = new BJoin();
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
