<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\User as BaseUser;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 */
class User extends BaseUser
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
