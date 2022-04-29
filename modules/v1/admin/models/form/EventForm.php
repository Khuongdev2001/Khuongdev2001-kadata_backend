<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\Event;
use yii\behaviors\TimestampBehavior;

class EventForm extends Event
{
    public $customer;
    public $staff;
    public $date_start_value;

    public function fields()
    {
        return array_merge(parent::fields(), [
            "customer" => "customerEvents",
            "staff" => "staffEvents"
        ]);
    }

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

    public function rules()
    {
        return [
            [['name', 'customer', 'staff', 'date_start_value', 'code'], "required"],
            [['customer', 'date_start_value'], 'safe'],
            ['date_start_value', 'date', 'format' => 'yyyy-mm-dd'],
            ['date_start_value', function () {
                if (strtotime($this->date_start_value) < strtotime(date("YYYY-mm-dd"))) {
                    $this->addError("date_start_value", "Ngày được chọn đã là quá khứ");
                    return;
                }
                $event = self::find()->where([
                    "<>", "status", self::STATUS_DELETE
                ])->andWhere([
                    "like", "start_at", $this->date_start_value
                ])->one();
                if ($event && $event->id != $this->id) {
                    $this->addError("date_start_value", "Ngày này đã có sự kiện");
                }
            }],
            [['customer', 'staff'], function ($attribute) {
                if (!is_array($this[$attribute])) {
                    $this->addError($attribute, "Invalid data type, only accept data type is array");
                }
            }]
        ];
    }
}