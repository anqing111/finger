<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BPerconf]].
 *
 * @see BPerconf
 */
class BPerconfQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BPerconf[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BPerconf|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
