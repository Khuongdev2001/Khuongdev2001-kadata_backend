<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\Customer as BaseCustomer;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customers".
 */
class Customer extends BaseCustomer
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
