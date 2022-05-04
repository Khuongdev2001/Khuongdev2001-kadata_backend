<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\WageStaff as BaseWageStaff;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "wage_staffs".
 */
class WageStaff extends BaseWageStaff
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = -99;

    public function getTextStatus()
    {
        return [
            self::STATUS_ACTIVE => "Đã chuyển lương",
            self::STATUS_INACTIVE => "Đã tính lương"
        ];
    }

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
