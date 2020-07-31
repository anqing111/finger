<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_positiontype}}".
 *
 * @property int $id 自增id
 * @property string $sPositiontypeName 职位类别名称
 * @property int $iPositiontypeID 父职位id
 * @property string $dCreatTime 创建时间
 */
class BPositiontype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_positiontype}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iPositiontypeID'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sPositiontypeName'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'sPositiontypeName' => Yii::t('app', '职位类别名称'),
            'iPositiontypeID' => Yii::t('app', '父职位id'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BPositiontypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BPositiontypeQuery(get_called_class());
    }

    public static function getPositionType($params)
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
            ->select(['tb_b_positiontype.id','tb_b_positiontype.sPositiontypeName','cName'=>'b.sPositiontypeName','cid'=>'b.id','ccName'=>'c.sPositiontypeName','ccid'=>'c.id'])
            ->leftJoin(['b' => self::tableName()], 'b.iPositiontypeID = tb_b_positiontype.id')
            ->leftJoin(['c' => EPositiontype::tableName()], 'c.iPositiontypeID = b.id')
            ->where($params)
            ->all();

        return $industr;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertPositionType($params)
    {
        $post = new BPositiontype();
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

    public static function updatePositionType($params)
    {
        //新增项目
        $obj = new BPositiontype();
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

    public static function batchInsertPositionType($params)
    {
        $connection = \Yii::$app->db;
        //数据批量入库
        $flag = $connection->createCommand()->batchInsert(
            ''.BPositiontype::tableName().'',
            ['sPositiontypeName','iPositiontypeID'],//字段
            $params
        )->execute();

        return $flag;
    }
}
