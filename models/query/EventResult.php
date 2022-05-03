<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\EventResult as BaseEventResult;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event_results".
 */
class EventResult extends BaseEventResult
{
    const STATUS_DELETE = -99;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;


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

    public static function findOneActive($id)
    {
        return self::find()->where(["id" => $id])->andWhere(["<>", "status", self::STATUS_ACTIVE])->one();
    }
}
