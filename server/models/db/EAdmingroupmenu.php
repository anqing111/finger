<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "{{%e_admingroupmenu}}".
 *
 * @property int $id 自增id
 * @property int $pid 角色id
 * @property int $iMenuID 菜单id
 * @property int $iPMenuID 父菜单id
 * @property string $dCreatTime 创建时间
 */
class EAdmingroupmenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%e_admingroupmenu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'iMenuID', 'iPMenuID'], 'integer'],
            [['dCreatTime'], 'safe'],
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
            'iMenuID' => Yii::t('app', '菜单id'),
            'iPMenuID' => Yii::t('app', '父菜单id'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EAdmingroupmenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EAdmingroupmenuQuery(get_called_class());
    }
}
