<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BMenu]].
 *
 * @see BMenu
 */
class BMenuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BMenu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BMenu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
