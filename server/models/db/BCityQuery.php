<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BCity]].
 *
 * @see BCity
 */
class BCityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BCity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BCity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
