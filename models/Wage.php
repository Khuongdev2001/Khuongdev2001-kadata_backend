<?php

namespace app\models;

use Yii;
use \app\models\base\Wage as BaseWage;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "wages".
 */
class Wage extends BaseWage
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
