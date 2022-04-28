<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\Staff;
use yii\behaviors\TimestampBehavior;

class StaffForm extends Staff
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            "staff_level_name" => 'staffLevelName'
        ]);
    }

    public function rules()
    {
        return [
            [["staff_code"], "safe"],
            [["fullname", "phone", "address", "bank_account_name"], "string", "max" => 255],
            [["bank_account_number", "work_day"], "integer"],
            [["staff_level"], "exist", "targetClass" => StaffLevelForm::class, "targetAttribute" => ["staff_level" => "id"], "filter" => [
                "=", "status", 1
            ]],
            [['status'], 'default', 'value' => 1],
            [["fullname", "staff_level"], "required"]
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
