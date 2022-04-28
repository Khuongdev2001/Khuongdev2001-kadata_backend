<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\query\Post]].
 *
 * @see \app\models\query\Post
 */
class PostQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\query\Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
