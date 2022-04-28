<?php

namespace app\modules\v1\admin\models\search;

use yii\data\ActiveDataProvider;
use app\models\Customer;

class CustomerSearch extends Customer
{
    public $search;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return [
            [["search"], "string"]
        ];
    }


    public function search($params): ActiveDataProvider
    {
        $query = self::find()->where(["<>", "status", -99]);

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
            ['like', 'customer_code', $this->search],
            ['like', 'surrogate', $this->search],
            ['like', 'name', $this->search],
            ['like', 'phone', $this->search],
            ['like', 'address', $this->search]
        ]);
        return $dataProvider;
    }
}
