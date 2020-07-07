<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EStudentcertificate]].
 *
 * @see EStudentcertificate
 */
class EStudentcertificateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EStudentcertificate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EStudentcertificate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
