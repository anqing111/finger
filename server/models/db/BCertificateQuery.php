<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BCertificate]].
 *
 * @see BCertificate
 */
class BCertificateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BCertificate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BCertificate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
