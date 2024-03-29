<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_instructor}}".
 *
 * @property int $id 自增id
 * @property string $sName 姓名
 * @property int $year 工作经验
 * @property string $info 个人简介
 * @property string $headportrait 头像
 * @property string $bigheadportrait 大头像
 * @property int $isRec 是否推荐到首页
 * @property string $dCreatTime 创建时间
 */
class EInstructor extends \yii\db\ActiveRecord
{
    /*
    * 是否推荐到首页
    * 1 是 0 否
    * */
    const YES = 1;
    const NO = 0;
    public static $_isRec = [
        self::YES => '是',
        self::NO => '否',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_instructor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'isRec'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sName'], 'string', 'max' => 20],
            [['info'], 'string', 'max' => 255],
            [['headportrait', 'bigheadportrait'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'sName' => Yii::t('app', '姓名'),
            'year' => Yii::t('app', '工作经验'),
            'info' => Yii::t('app', '个人简介'),
            'headportrait' => Yii::t('app', '头像'),
            'bigheadportrait' => Yii::t('app', '大头像'),
            'isRec' => Yii::t('app', '是否推荐到首页'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EInstructorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EInstructorQuery(get_called_class());
    }


    //获取所有著作
    public function getInstructorbook()
    {
        return $this->hasMany(EInstructorbook::className(),['tid' => 'id'])->asArray();
    }

    //获取所有视频
    public function getInstructorvideo()
    {
        return $this->hasMany(EInstructorvideo::className(),['tid' => 'id'])->asArray();
    }

    public static function getInstructor($params)
    {
        //AR创建关联查询，查询的结果是2个sql语句拼接的结果，并不是sql语句的联合查询
        $profile = self::find()
            ->joinWith([
                'instructorbook b',
                'instructorvideo c'
            ])->where($params)->asArray()->one();

        return $profile;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertInstructor($params)
    {
        $post = new EInstructor();
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

    public static function updateInstructor($params)
    {
        //新增项目
        $obj = new EInstructor();
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
