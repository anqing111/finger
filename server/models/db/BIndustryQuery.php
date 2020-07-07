<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BIndustry]].
 *
 * @see BIndustry
 */
class BIndustryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BIndustry[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BIndustry|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
