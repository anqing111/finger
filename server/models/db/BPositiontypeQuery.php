<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BPositiontype]].
 *
 * @see BPositiontype
 */
class BPositiontypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BPositiontype[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BPositiontype|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
