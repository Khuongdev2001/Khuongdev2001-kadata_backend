<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\query\Migration]].
 *
 * @see \app\models\query\Migration
 */
class MigrationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\query\Migration[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\Migration|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
