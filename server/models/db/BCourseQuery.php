<?php

namespace app\models\db;
use yii\base\ArrayableTrait;
/**
 * This is the ActiveQuery class for [[BCourse]].
 *
 * @see BCourse
 */
class BCourseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BCourse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BCourse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
