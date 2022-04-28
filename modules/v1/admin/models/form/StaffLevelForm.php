<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\StaffLevel;
use yii\behaviors\TimestampBehavior;

class StaffLevelForm extends StaffLevel
{
    public function rules()
    {
        return [
            [["name", "pay_level", "allowance_pay"], "required"],
            ["name", "unique", "filter" => [
                "=", "status", 1
            ]],
            [["pay_level", "allowance_pay"], "integer"],
            [['status'], 'default', 'value' => 1],
            ['status', 'in',  'range' => [0, 1], 'allowArray' => true],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date("Y-m-d h:i:s"),
            ],
        ];
    }
}
