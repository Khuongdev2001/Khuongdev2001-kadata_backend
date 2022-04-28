<?php

namespace app\modules\v1\admin\models\form;

use app\models\Customer;

class CustomerForm extends Customer
{
    public function rules()
    {
        return [
            [['surrogate', 'name', 'phone', 'address'], 'string', 'max' => 255],
            [["surrogate", "name"], "required"],
            [['status'], 'integer'],
            ['status', 'default', 'value' => 1],
            ['name', 'unique', 'filter' => [
                '=', 'status', 1
            ]],
            [['status'], 'in', 'range' => [0, 1, -99], 'allowArray' => true],
        ];
    }
}
