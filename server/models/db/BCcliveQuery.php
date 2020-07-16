<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BCclive]].
 *
 * @see BCclive
 */
class BCcliveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BCclive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BCclive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
