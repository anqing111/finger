<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[EDefensevideo]].
 *
 * @see EDefensevideo
 */
class EDefensevideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EDefensevideo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EDefensevideo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
