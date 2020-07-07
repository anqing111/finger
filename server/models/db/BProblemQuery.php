<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BProblem]].
 *
 * @see BProblem
 */
class BProblemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BProblem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BProblem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
