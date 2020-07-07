<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EStudentprofile]].
 *
 * @see EStudentprofile
 */
class EStudentprofileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EStudentprofile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EStudentprofile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
