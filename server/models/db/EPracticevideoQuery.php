<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EPracticevideo]].
 *
 * @see EPracticevideo
 */
class EPracticevideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EPracticevideo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EPracticevideo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
