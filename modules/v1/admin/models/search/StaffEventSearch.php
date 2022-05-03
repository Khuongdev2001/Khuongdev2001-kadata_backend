<?php

namespace app\modules\v1\admin\models\search;

use app\modules\v1\admin\models\StaffEvent;
use yii\data\ActiveDataProvider;

class StaffEventSearch extends StaffEvent
{
    public function fields()
    {
        return array_merge(parent::fields(),[
            "staff_name"=>"staffName"
        ]);
    }

    public function getStaffName()
    {
        return $this->staff->fullname;
    }

    public function rules()
    {
        return [
            [["customer_id", "staff_id", "created_at", "updated_at", "event_id"], "safe"]
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
            'staff_id'=>$this->staff_id
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