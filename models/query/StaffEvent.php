<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\StaffEvent as BaseStaffEvent;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "staff_events".
 */
class StaffEvent extends BaseStaffEvent
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
