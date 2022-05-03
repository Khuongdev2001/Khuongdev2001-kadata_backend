<?php

namespace app\modules\v1\admin\models\search;

use app\modules\v1\admin\models\EventResult;
use yii\data\ActiveDataProvider;

class EventResultSearch extends EventResult
{
    public $search;

    public function fields()
    {
        return array_merge(parent::fields(), [
            "customer" => "customer",
            "customer_name" => function () {
                return $this->customer->name;
            },
            "seller" => "seller",
            "seller_name" => function () {
                return $this->seller?->fullname;
            },
            "consultant" => "consultant",
            "consultant_name" => function () {
                return $this->consultant->fullname;
            },
            "statusText" => "statusText"
        ]);
    }

    public function getStatusText()
    {
        return [self::STATUS_ACTIVE => "Đã Hoàn Thành", self::STATUS_INACTIVE => "Chưa Hoàn Thành"][$this->status];
    }

    public function rules()
    {
        return [
            [["id", "consultant_id", "search", "event_id", "seller_id", "customer_id", "buyer_name", "buyer_phone", "turnover", "status", "paid_at", "created_at"], "safe"]
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = self::find()
            ->joinWith("seller")
            ->joinWith("customer")
            ->joinWith("consultant")
            ->where(["<>", "event_results.status", self::STATUS_DELETE])
            ->andWhere(["event_id" => $params["event_id"]]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'params' => $params
            ],
            'sort' => [
                'params' => $params
            ]
        ]);
        $this->load($params, "");
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }

        $query->andFilterWhere(['or',
            ['like', 'buyer_name', $this->search],
            ['like', 'buyer_phone', $this->search],
            ['like', 'turnover', $this->search],
        ]);
        return $dataProvider;
    }
}