<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BUserbaseinfo]].
 *
 * @see BUserbaseinfo
 */
class BUserbaseinfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BUserbaseinfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BUserbaseinfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
