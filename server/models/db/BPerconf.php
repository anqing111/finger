<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_perconf}}".
 *
 * @property int $pid 角色id
 * @property string $sAdminGroupName
 * @property string $dCreatTime 创建时间
 */
class BPerconf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_perconf}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dCreatTime'], 'safe'],
            [['sAdminGroupName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pid' => Yii::t('app', '角色id'),
            'sAdminGroupName' => Yii::t('app', 'S Admin Group Name'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BPerconfQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BPerconfQuery(get_called_class());
    }
}
