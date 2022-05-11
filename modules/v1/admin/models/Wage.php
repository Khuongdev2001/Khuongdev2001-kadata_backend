<?php

namespace app\modules\v1\admin\models;

class Wage extends \app\models\query\Wage
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            "staff" => "staff",
            "level" => function () {
                return $this->staff->staffLevel->name;
            },
            "staff_code" => function () {
                return $this->staff->staff_code;
            },
            "fullname" => function () {
                return $this->staff->fullname;
            },
            "phone" => function () {
                return $this->staff->phone;
            },
            "status_text" => 'statusText',
            "status_check" => function () {
                return $this->status;
            }
        ]);
    }
}