<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\query\AuthItemChild]].
 *
 * @see \app\models\query\AuthItemChild
 */
class AuthItemChildQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\query\AuthItemChild[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\AuthItemChild|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
