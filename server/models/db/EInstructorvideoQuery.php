<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EInstructorvideo]].
 *
 * @see EInstructorvideo
 */
class EInstructorvideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EInstructorvideo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EInstructorvideo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
