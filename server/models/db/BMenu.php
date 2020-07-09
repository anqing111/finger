<?php

namespace app\models\db;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%b_menu}}".
 *
 * @property int $iMenuID 菜单id
 * @property string $sMenuName 菜单名称
 * @property int $iParentMenuID 父菜单id
 * @property string|null $sURL url
 * @property string $dCreatTime 创建时间
 */
class BMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iParentMenuID'], 'integer'],
            [['dCreatTime'], 'safe'],
            [['sMenuName'], 'string', 'max' => 30],
            [['sURL'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iMenuID' => Yii::t('app', '菜单id'),
            'sMenuName' => Yii::t('app', '菜单名称'),
            'iParentMenuID' => Yii::t('app', '父菜单id'),
            'sURL' => Yii::t('app', 'url'),
            'dCreatTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BMenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BMenuQuery(get_called_class());
    }

    public function getMenus()
    {
        $industry = $this->hasMany(EAdmingroupmenu::className(),['iMenuID' => 'iMenuID'])->asArray();
        return $industry;
    }

    public function getCMenus()
    {
        $industry = $this->hasMany(BMenu::className(),['iParentMenuID' => 'iMenuID'])->asArray();
        return $industry;
    }

    public static function getMenuList($params)
    {
        //AR创建关联查询，查询的结果是2个sql语句拼接的结果，并不是sql语句的联合查询
        $menu = self::find()->select(['tb_b_menu.sMenuName', 'tb_b_menu.iMenuID','tb_b_menu.sURL','tb_b_menu.iParentMenuID'])
            ->joinWith([
                'menus b'=>function(Query $query){
                     $query->select([
                         'b.iMenuID'
                     ])->where(['iPMenuID'=>0]);
                },
                'cMenus c'=>function(Query $query){
                    $query->select([
                        'c.iMenuID',
                        'c.iParentMenuID',
                        'c.sMenuName',
                        'c.sURL',
                    ]);
                },
            ])->where($params)->asArray()->all();

        return $menu;
    }
}
