<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_msg}}".
 *
 * @property int $iMsgID
 * @property string $sPhone
 * @property string|null $sMsg
 * @property string $dCreateTime
 * @property int $iUserID
 * @property int|null $sendresult
 */
class BMsg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_msg}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sPhone', 'iUserID'], 'required'],
            [['dCreateTime'], 'safe'],
            [['iUserID', 'sendresult'], 'integer'],
            [['sPhone'], 'string', 'max' => 20],
            [['sMsg'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iMsgID' => Yii::t('app', 'I Msg ID'),
            'sPhone' => Yii::t('app', 'S Phone'),
            'sMsg' => Yii::t('app', 'S Msg'),
            'dCreateTime' => Yii::t('app', 'D Create Time'),
            'iUserID' => Yii::t('app', 'I User ID'),
            'sendresult' => Yii::t('app', 'Sendresult'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BMsgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BMsgQuery(get_called_class());
    }
}
