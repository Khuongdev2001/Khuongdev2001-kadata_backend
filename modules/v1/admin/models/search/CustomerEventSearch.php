<?php

namespace app\modules\v1\admin\models\search;

use app\modules\v1\admin\models\CustomerEvent;
use yii\data\ActiveDataProvider;

class CustomerEventSearch extends CustomerEvent
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            "customer_name" => "customerName"
        ]);
    }

    public function getCustomerName()
    {
        return $this->customer->name;
    }

    public function rules()
    {
        return [
            [["event_id", "customer_id", "qty", "created_at"], "safe"]
        ];
    }

    public function search($params)
    {
        $query = self::find();
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
            'event_id' => $this->event_id,
            'customer_id' => $this->customer_id,
            'qty' => $this->qty
        ]);

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }
        return $dataProvider;
    }
}