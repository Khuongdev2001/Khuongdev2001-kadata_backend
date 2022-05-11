<?php

namespace app\modules\v1\admin\models;

class WageUpdateForm extends \app\models\query\Wage
{
    public function rules()
    {
        return [
            ["allowance_pay", "integer", "min" => 0],
            ["allowance_pay", "required"],
            ['status', 'in', 'range' => $this->getStatus(), 'allowArray' => true]
        ];
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            "staff" => "staff",
            "level" => function () {
                return $this->staff->staffLevel->name;
            },
            "total_pay" => function () {
                return number_format($this->total_pay) . " VNĐ";
            },
            "basic_pay" => function () {
                return number_format($this->basic_pay) . " VNĐ";
            },
            "allowance_pay" => function () {
                return number_format($this->allowance_pay) . " VNĐ";
            }
        ]);
    }
}