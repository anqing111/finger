<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[ETrainingvideo]].
 *
 * @see ETrainingvideo
 */
class ETrainingvideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ETrainingvideo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ETrainingvideo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
