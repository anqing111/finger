<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EInstructor]].
 *
 * @see EInstructor
 */
class EInstructorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EInstructor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EInstructor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
