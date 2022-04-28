<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\Migration as BaseMigration;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "migration".
 */
class Migration extends BaseMigration
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
