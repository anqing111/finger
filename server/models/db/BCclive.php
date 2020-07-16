<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_cclive}}".
 *
 * @property int $cid 自增id
 * @property string $id 直播间id
 * @property string $name 直播间名称
 * @property string $desc 直播间描述
 * @property int $status 状态
 * @property string $playPass 播放端密码
 * @property string $assistantPass 助教密码
 * @property int $authType 验证类型
 * @property int $templateType 模版类型
 * @property int $barrage 是否开启弹幕
 * @property string $liveStartTime 直播开始时间
 * @property string $playerBackgroundHint 播放器提示语
 * @property string $md5sign md5验证
 * @property string $dCreatTime 创建时间
 */
class BCclive extends \yii\db\ActiveRecord
{
    /*
     * 直播间-状态
     * 10：正常； 20：关闭； 40：已封禁
     * */
    const NORMAL = 10;
    const CLOSE = 20;
    const BAN = 40;
    public static $_status = [
        self::NORMAL => '正常',
        self::CLOSE => '关闭',
        self::BAN => '已封禁',
    ];
    /*
     * 直播间-验证类型
     * 1：单密码验证； 2：免密码验证； 3：白名单验证
     * */
    const PASSWORD = 1;
    const NOPASSWORD = 2;
    const WHITELIST = 3;
    public static $_authType = [
        self::PASSWORD => '单密码验证',
        self::NOPASSWORD => '免密码验证',
        self::WHITELIST => '白名单验证',
    ];
    /*
     * 直播间-是否开启弹幕
     * 0：不开启；1：开启
     * */
    const UNOPEN = 0;
    const OPEN = 1;
    public static $_barrage = [
        self::UNOPEN => '不开启',
        self::OPEN => '开启'
    ];
    /*
     * 直播间-模版类型
     * 1：视频； 2：问答、视频、聊天； 3：视频、聊天  4：视频、文档、聊天  5 ：视频、问答、文档、聊天  6：视频、问答
     * */
    const VIDEO = 1;
    const VQACHAT = 2;
    const VCHAT = 3;
    const VWCHAT = 4;
    const VWQACHAT = 5;
    const VQA = 6;
    public static $_templateType = [
        self::VIDEO => '视频',
        self::VQACHAT => '问答、视频、聊天',
        self::VCHAT => '视频、聊天',
        self::VWCHAT => '视频、文档、聊天',
        self::VWQACHAT => '视频、问答、文档、聊天',
        self::VQA => '视频、问答',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_cclive}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'authType', 'templateType', 'barrage'], 'integer'],
            [['liveStartTime', 'dCreatTime'], 'safe'],
            [['id', 'playPass', 'assistantPass'], 'string', 'max' => 50],
            [['name', 'playerBackgroundHint'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 255],
            [['md5sign'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cid' => Yii::t('app', '自增id'),
            'id' => Yii::t('app', '直播间id'),
            'name' => Yii::t('app', '直播间名称'),
            'desc' => Yii::t('app', '直播间描述'),
            'status' => Yii::t('app', '状态'),
            'playPass' => Yii::t('app', '播放端密码'),
            'assistantPass' => Yii::t('app', '助教密码'),
            'authType' => Yii::t('app', '验证类型'),
            'templateType' => Yii::t('app', '模版类型'),
            'barrage' => Yii::t('app', '是否开启弹幕'),
            'liveStartTime' => Yii::t('app', '直播开始时间'),
            'playerBackgroundHint' => Yii::t('app', '播放器提示语'),
            'md5sign' => Yii::t('app', 'md5验证'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BCcliveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BCcliveQuery(get_called_class());
    }

    private static function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function insertCclive($params)
    {
        $post = new BCclive();
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

    public static function updateCclive($params)
    {
        //新增项目
        $obj = new BCclive();
        //过滤无效字段（将数据表中未定义的字段去除）
        $params = self::filterInputFields($params,$obj->attributeLabels());

        $post = $obj::findOne($params['cid']);

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
        return $params['cid'];
    }
}
