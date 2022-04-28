<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\query\Event]].
 *
 * @see \app\models\query\Event
 */
class EventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\query\Event[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\Event|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
