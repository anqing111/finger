<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_video}}".
 *
 * @property int $id 自增id
 * @property int $iUserID 学员id
 * @property int $iResumeID 简历id
 * @property string $sProblemName 标题
 * @property string $sVideoUrl 视频
 * @property string $sVideoImg 背景图
 * @property int $isRec 是否推荐到首页
 * @property string $dCreatTime 创建时间
 */
class BVideo extends \yii\db\ActiveRecord
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
        return '{{%b_video}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iUserID'], 'required'],
            [['iUserID', 'iResumeID', 'isRec'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sProblemName'], 'string', 'max' => 100],
            [['sVideoUrl', 'sVideoImg'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增id'),
            'iUserID' => Yii::t('app', '学员id'),
            'iResumeID' => Yii::t('app', '简历id'),
            'sProblemName' => Yii::t('app', '标题'),
            'sVideoUrl' => Yii::t('app', '视频'),
            'sVideoImg' => Yii::t('app', '背景图'),
            'isRec' => Yii::t('app', '是否推荐到首页'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }
    public static function getVideolist()
    {
        //查询生成器查询
        $query = (new \yii\db\Query());
        $video = $query->from(self::tableName())
            ->select(['id','sProblemName','isRec','sNick','sVideoUrl'])
            ->leftJoin(['b' => BUserbaseinfo::tableName()], self::tableName().'.iUserID = b.iUserID')
            ->orderBy('id desc')
            ->all();

        return $video;
    }
    /**
     * {@inheritdoc}
     * @return BVideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BVideoQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertVideo($params)
    {
        $post = new BVideo();
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

    public static function updateVideo($params)
    {
        //新增项目
        $obj = new BVideo();
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
