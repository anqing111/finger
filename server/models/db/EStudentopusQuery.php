<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EStudentopus]].
 *
 * @see EStudentopus
 */
class EStudentopusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EStudentopus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EStudentopus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
