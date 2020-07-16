<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_professional}}".
 *
 * @property int $id 自增id
 * @property int $iUserID 学员id
 * @property int $iResumeID 简历id
 * @property string $sProfessionalName 专业技能
 * @property int $isRec 是否推荐到首页
 * @property string $dCreatTime 创建时间
 */
class BProfessional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_professional}}';
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
            [['sProfessionalName'], 'string', 'max' => 100],
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
            'sProfessionalName' => Yii::t('app', '专业技能'),
            'isRec' => Yii::t('app', '是否推荐到首页'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BProfessionalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BProfessionalQuery(get_called_class());
    }
}
