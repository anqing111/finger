<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BMsg]].
 *
 * @see BMsg
 */
class BMsgQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BMsg[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BMsg|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
