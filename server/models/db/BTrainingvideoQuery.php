<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BTrainingvideo]].
 *
 * @see BTrainingvideo
 */
class BTrainingvideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BTrainingvideo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BTrainingvideo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
