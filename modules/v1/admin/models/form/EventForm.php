<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\Event;
use app\modules\v1\admin\models\Customer;

class EventForm extends Event
{
    public $customer;
    public $staff;
    public $date_start_value;

    public function rules()
    {
        return [
            [['name', 'customer', 'staff',], "required"],
            [['customer', 'date_start_value'], 'safe']
        ];
    }
}