<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EInstructorbook]].
 *
 * @see EInstructorbook
 */
class EInstructorbookQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EInstructorbook[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EInstructorbook|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
