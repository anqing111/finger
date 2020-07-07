<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[ELecturer]].
 *
 * @see ELecturer
 */
class ELecturerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ELecturer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ELecturer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
