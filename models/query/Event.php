<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\Event as BaseEvent;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "events".
 */
class Event extends BaseEvent
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
