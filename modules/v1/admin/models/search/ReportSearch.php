<?php

namespace app\modules\v1\admin\models\search;

use app\modules\v1\admin\models\Report;
use yii\data\ActiveDataProvider;

class ReportSearch extends Report
{
    public $search;

    public function rules()
    {
        return [
            [["report_title", "report_content", "customer_id", "search"], "string"],
            [['created_at', 'updated_at', 'done_at'], 'safe'],
        ];
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            "status_text" => "statusText",
            "report_content" => function () {
                return strip_tags($this->report_content);
            },
            "customer" => "customer"
        ]);
    }


    public function getNameCustomer()
    {
        return $this->customer->name;
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
        if ($this->done_at !== null) {
            $query->andFilterWhere(['between', 'done_at', $this->done_at, $this->done_at + 3600 * 24]);
        }

        $query->andFilterWhere(['like', 'report_title', $this->search])
            ->orFilterWhere(['like', 'report_content', $this->search]);
        return $dataProvider;
    }
}
