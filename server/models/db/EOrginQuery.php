<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EOrgin]].
 *
 * @see EOrgin
 */
class EOrginQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EOrgin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EOrgin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
