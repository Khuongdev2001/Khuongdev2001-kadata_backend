<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\StaffLevel as BaseStaffLevel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "staff_levels".
 */
class StaffLevel extends BaseStaffLevel
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
