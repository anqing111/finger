<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_article}}".
 *
 * @property int $id 自增id
 * @property string $title 标题
 * @property string $author 作者
 * @property string|null $content 内容
 * @property int $status 状态
 * @property int $type 类型
 * @property string $dReleaseTime 发布时间
 * @property int $click 点击率
 * @property string $picture 图片
 * @property int $isRec 是否推荐到首页
 * @property string $dCreatTime 创建时间
 */
class BArticle extends \yii\db\ActiveRecord
{
    //网站资讯类文章
    const INFORMATION_TYPE = 1;
    //技能薪酬类文章
    const TECHNICAL_TYPE = 2;
    /*
     * 文章-状态
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
        return '{{%b_article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['status', 'type', 'click', 'isRec'], 'integer'],
            [['dReleaseTime', 'dCreatTime'], 'safe'],
            [['title', 'picture'], 'string', 'max' => 100],
            [['author'], 'string', 'max' => 50],
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
            'author' => Yii::t('app', '作者'),
            'content' => Yii::t('app', '内容'),
            'status' => Yii::t('app', '状态'),
            'type' => Yii::t('app', '类型'),
            'dReleaseTime' => Yii::t('app', '发布时间'),
            'click' => Yii::t('app', '点击率'),
            'picture' => Yii::t('app', '图片'),
            'isRec' => Yii::t('app', '是否推荐到首页'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BArticleQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertArticle($params)
    {
        $post = new BArticle();
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

    public static function updateArticle($params)
    {
        //新增项目
        $obj = new BArticle();
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
