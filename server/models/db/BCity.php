<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%b_city}}".
 *
 * @property int $iCityID 城市id
 * @property string $sCityName 城市名称
 * @property string $sCityPY 城市首字母
 * @property string $sCoordinates 城市坐标
 * @property int $iHotCity 热门城市
 * @property string $sPingYin 城市全拼
 * @property int $iProID 省份id
 * @property string $positionName 城市全称
 * @property int $level 城市等级ID
 * @property string $dCreateTime 创建时间
 */
class BCity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_city}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iHotCity', 'iProID', 'level'], 'integer'],
            [['dCreateTime'], 'safe'],
            [['sCityName'], 'string', 'max' => 20],
            [['sCityPY'], 'string', 'max' => 1],
            [['sCoordinates'], 'string', 'max' => 50],
            [['sPingYin', 'positionName'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iCityID' => Yii::t('app', '城市id'),
            'sCityName' => Yii::t('app', '城市名称'),
            'sCityPY' => Yii::t('app', '城市首字母'),
            'sCoordinates' => Yii::t('app', '城市坐标'),
            'iHotCity' => Yii::t('app', '热门城市'),
            'sPingYin' => Yii::t('app', '城市全拼'),
            'iProID' => Yii::t('app', '省份id'),
            'positionName' => Yii::t('app', '城市全称'),
            'level' => Yii::t('app', '城市等级ID'),
            'dCreateTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BCityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BCityQuery(get_called_class());
    }
}
