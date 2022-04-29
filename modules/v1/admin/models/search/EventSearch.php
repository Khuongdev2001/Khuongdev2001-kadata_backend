<?php

namespace app\modules\v1\admin\models\search;

use yii\data\ActiveDataProvider;
use app\modules\v1\admin\models\Event;

class EventSearch extends Event
{
    public $search;

    public function fields()
    {
        return array_merge(parent::fields(), [
            "countCustomer" => "countCustomerAssign",
            "countStaff" => "countStaffAssign"
        ]);
    }

    public function rules()
    {
        return [
            [["search", "name", "code", "created_at", "updated_at"], "safe"]
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = self::active();
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
            ['like', 'name', $this->search],
            ['like', 'code', $this->search],
            ['like', 'status', $this->search],
            ['like', 'create_by', $this->search],
            ['like', 'created_at', $this->search]
        ]);
        return $dataProvider;
    }
}
