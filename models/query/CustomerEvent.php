<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\CustomerEvent as BaseCustomerEvent;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customer_events".
 */
class CustomerEvent extends BaseCustomerEvent
{

    public function fields()
    {
        return array_merge(parent::fields(), [
            "id" => 'customerId',
            "name" => "customerName"
        ]);
    }

    public function getCustomerName()
    {
        return $this->hasOne(Customer::class, ["id" => "customer_id"])->one()->name;
    }

    public function getCustomerId()
    {
        return $this->hasOne(Customer::class, ["id" => "customer_id"])->one()->id;
    }

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
