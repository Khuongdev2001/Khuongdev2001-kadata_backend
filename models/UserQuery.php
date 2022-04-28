<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\query\User]].
 *
 * @see \app\models\query\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\query\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
