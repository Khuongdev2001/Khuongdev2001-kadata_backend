<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\AccessToken as BaseAccessToken;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "access_token".
 */
class AccessToken extends BaseAccessToken
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
