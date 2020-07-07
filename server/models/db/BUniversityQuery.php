<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BUniversity]].
 *
 * @see BUniversity
 */
class BUniversityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BUniversity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BUniversity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
