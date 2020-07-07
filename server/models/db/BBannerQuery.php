<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BBanner]].
 *
 * @see BBanner
 */
class BBannerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BBanner[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BBanner|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
