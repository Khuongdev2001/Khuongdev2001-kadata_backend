<?php

namespace app\modules\v1\admin\models;

use app\models\query\StaffEvent as StaffEventBase;

class StaffEvent extends StaffEventBase
{

    public function fields()
    {
        return array_merge(parent::fields(), [
            "customer" => "customer",
            "staff" => "staff"
        ]);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ["id" => "customer_id"])->one();
    }

    public function getStaff()
    {
        return $this->hasOne(Staff::class, ["id" => "staff_id"])->one();
    }
}