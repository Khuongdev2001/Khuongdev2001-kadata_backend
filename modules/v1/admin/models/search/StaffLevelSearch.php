<?php

namespace app\modules\v1\admin\models\search;

use app\modules\v1\admin\models\StaffLevel;
use yii\data\ActiveDataProvider;

class StaffLevelSearch extends StaffLevel
{
    public $search;

    public function rules()
    {
        return [
            [["name", "pay_level", "status", "allowance_pay", "search"], "safe"]
        ];
    }

    public function search($params)
    {
        $query = self::find()->where(["status" => self::STATUS_ACTIVE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params, "");
        if (!$this->validate()) {
            return $dataProvider;
        }
        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }
        $query->andFilterWhere(['like', 'name', $this->search])
            ->andFilterWhere(['like', 'pay_level', $this->search])
            ->andFilterWhere(['like', 'allowance_pay', $this->search]);
        return $dataProvider;
    }
}
