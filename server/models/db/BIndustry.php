<?php

namespace app\models\db;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%b_industry}}".
 *
 * @property int $id 自增id
 * @property string $sIndustryName 行业名称
 * @property int $industryID 父行业id
 * @property string $dCreatTime 创建时间
 */
class BIndustry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_industry}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['industryID'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sIndustryName'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'sIndustryName' => Yii::t('app', '行业名称'),
            'industryID' => Yii::t('app', '父行业id'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    public function getBIndustrys()
    {
        $industry = $this->hasMany(self::className(),['industryID' => 'id'])->asArray();
        return $industry;
    }

    /**
     * {@inheritdoc}
     * @return BIndustryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BIndustryQuery(get_called_class());
    }

    public static function getIndustry($params)
    {
        //AR创建关联查询，查询的结果是2个sql语句拼接的结果，并不是sql语句的联合查询
//        $industr = self::find()->select(['tb_b_industry.sIndustryName', 'tb_b_industry.id'])
//            ->joinWith([
//                'bIndustrys b'=>function(Query $query){
//                     $query->select([
//                         'b.sIndustryName',
//                         'b.industryID',
//                         'b.id'
//                     ]);
//                },
//            ])->where($params)->asArray()->all();

        //查询生成器查询
        $query = (new \yii\db\Query());
        $industr = $query->from(self::tableName())
            ->select(['tb_b_industry.id','tb_b_industry.sIndustryName','cName'=>'b.sIndustryName','cid'=>'b.id'])
            ->leftJoin(['b' => self::tableName()], 'b.industryID = tb_b_industry.id')
            ->where($params)
            ->all();

        return $industr;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertIndustry($params)
    {
        $post = new BIndustry();
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

    public static function updateIndustry($params)
    {
        //新增项目
        $obj = new BIndustry();
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

    public static function batchInsertIndustry($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.BIndustry::tableName().'',
            ['sIndustryName','industryID'],//字段
            $params
        )->execute();

        return $flag;
    }
}
