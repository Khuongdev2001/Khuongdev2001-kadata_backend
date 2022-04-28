<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\query\StaffEvent]].
 *
 * @see \app\models\query\StaffEvent
 */
class StaffEventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\query\StaffEvent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\StaffEvent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
