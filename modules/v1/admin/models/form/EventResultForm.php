<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\EventResult;
use app\modules\v1\admin\models\StaffEvent;
use Yii;
use yii\behaviors\TimestampBehavior;

class EventResultForm extends EventResult
{

    public function fields()
    {
        return array_merge(parent::fields(), [
            "customer_name" => function () {
                return $this->customer->name;
            },
            "consultant_name" => function () {
                return $this->consultant?->fullname;
            },
            "seller_name" => function () {
                return $this->seller?->fullname;
            }
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

    public function rules(): array
    {
        return [
            [["buyer_name", "buyer_phone", "customer_id", "consultant_id", "event_id", "turnover"], "required"],
            [["buyer_name", "buyer_phone"], "string", "max" => 255],
            [["turnover", "customer_id", "consultant_id", "event_id"], "integer"],
            [["event_id"], function () {
                $staffEvent = StaffEvent::find()
                    ->where(["customer_id" => $this->customer_id])
                    ->andWhere(["staff_id" => $this->consultant_id])
                    ->andWhere(["event_id" => $this->event_id])
                    ->one();
                if (!$staffEvent) {
                    $this->addError("event_id", "Không tồn tại sự kiện");
                }
            }]
        ];
    }
}