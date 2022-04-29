<?php

namespace app\modules\v1\admin\models\form;

use app\models\StaffEventQuery;
use yii\behaviors\TimestampBehavior;

class StaffEventForm extends StaffEventQuery
{
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date("Y-m-d h:i:s"),
            ],
        ];
    }
}