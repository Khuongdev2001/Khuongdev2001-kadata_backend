<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\Report as BaseReport;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reports".
 */
class Report extends BaseReport
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
