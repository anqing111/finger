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
 * @property int $isRec 是否推荐到首页
 * @property string $dCreatTime 创建时间
 */
class BVideo extends \yii\db\ActiveRecord
{
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
            [['sVideoUrl'], 'string', 'max' => 255],
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
            'isRec' => Yii::t('app', '是否推荐到首页'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BVideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BVideoQuery(get_called_class());
    }
}
