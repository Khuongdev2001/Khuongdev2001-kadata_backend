<?php

namespace app\modules\v1\admin\models\search;

use yii\data\ActiveDataProvider;

class WageSearch extends \app\models\query\Wage
{
    public $search;

    public function rules()
    {
        return [
            [["staff_id", "basic_pay", "allowance_pay", "total_pay", "status"], "integer"],
            [["created_at", "updated_at", "salaryed_at","search"], "safe"]
        ];
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            "staff" => "staff",
            "level" => function () {
                return $this->staff->staffLevel->name;
            },
            "total_pay" => function () {
                return number_format($this->total_pay) . " VNĐ";
            },
            "basic_pay" => function () {
                return number_format($this->basic_pay) . " VNĐ";
            },
            "allowance_pay" => function () {
                return number_format($this->allowance_pay) . " VNĐ";
            },
            "statusText"=>"statusText"
        ]);
    }

    public function search($params)
    {
        $query = self::find()
            ->leftJoin("staffs", "staffs.id=wages.staff_id");
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'basic_pay' => $this->basic_pay,
            'piece_pay' => $this->piece_pay,
            'allowance_pay' => $this->allowance_pay,
            'total_pay' => $this->total_pay,
            'salaryed_at' => $this->salaryed_at

        ]);
        $query->andFilterWhere(['like', 'fullname', $this->search])
            ->orFilterWhere(['like', 'phone', $this->search]);
        return $dataProvider;
    }
}