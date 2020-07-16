<?php

namespace app\models\db;

/**
 * This is the ActiveQuery class for [[BProfessional]].
 *
 * @see BProfessional
 */
class BProfessionalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BProfessional[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BProfessional|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
