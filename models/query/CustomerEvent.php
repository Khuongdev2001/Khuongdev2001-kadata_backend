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
