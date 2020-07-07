<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EPosition]].
 *
 * @see EPosition
 */
class EPositionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EPosition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EPosition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
