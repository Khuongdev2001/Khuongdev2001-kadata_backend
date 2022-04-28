<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\Report;
use yii\behaviors\TimestampBehavior;

class ReportForm extends Report
{

    public function fields()
    {
        return array_merge(
            parent::fields(),
            [
                "status_text" => "statusText",
                "customer" => "nameCustomer"
            ]
        );
    }

    public function getNameCustomer()
    {
        return $this->customer->name;
    }


    public function behaviors()
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
            [["report_content", "report_title", "customer_id"], "required"],
            [["customer_id"], "exist", 'filter' => [
                '!=', 'status', 1
            ]],
            [['created_at', 'updated_at', 'done_at'], 'safe'],
            [['customer_id', 'status'], 'integer'],
            [['status'], 'default', 'value' => 0],
            ['status', 'in',  'range' => [0, 1], 'allowArray' => true],
        ];
    }
}
