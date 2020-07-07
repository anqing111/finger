<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_orgin}}".
 *
 * @property int $id 自增id
 * @property int $pid 角色id
 * @property string $sOrginName 机构名称
 * @property string $dCreatTime 创建时间
 */
class EOrgin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_orgin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sOrginName'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'pid' => Yii::t('app', '角色id'),
            'sOrginName' => Yii::t('app', '机构名称'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EOrginQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EOrginQuery(get_called_class());
    }

    public static function getOrgin($params)
    {
        //查询生成器查询
        $query = (new \yii\db\Query());
        $industr = $query->from(self::tableName())
            ->select([self::tableName().'.id',self::tableName().'.sOrginName','sAdminGroupName'])
            ->leftJoin(['b' => BPerconf::tableName()], self::tableName().'.pid = b.id')
            ->where($params)
            ->orderBy(self::tableName().'.id desc')
            ->all();

        return $industr;
    }

    public static function getOrginByUser($params)
    {
        //查询生成器查询
        $query = (new \yii\db\Query());
        $industr = $query->from(self::tableName())
            ->select([self::tableName().'.sOrginName'])
            ->leftJoin(['b' => BUserbaseinfo::tableName()], self::tableName().'.id = b.oid')
            ->where($params)
            ->one();

        return $industr;
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertOrgin($params)
    {
        $post = new EOrgin();
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

    public static function updateOrgin($params)
    {
        //新增项目
        $obj = new EOrgin();
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
