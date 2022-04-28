<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\AuthAssignment as BaseAuthAssignment;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_assignment".
 */
class AuthAssignment extends BaseAuthAssignment
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
