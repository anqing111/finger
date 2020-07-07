<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BSkill]].
 *
 * @see BSkill
 */
class BSkillQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BSkill[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BSkill|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
