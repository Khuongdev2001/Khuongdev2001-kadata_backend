<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\Staff as BaseStaff;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "staffs".
 */
class Staff extends BaseStaff
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
