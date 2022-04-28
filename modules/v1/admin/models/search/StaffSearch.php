<?php

namespace app\modules\v1\admin\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\v1\admin\models\Staff;

class StaffSearch extends Staff
{
    public $search;

    public function fields()
    {
        return array_merge(parent::fields(), [
            "staff_level_name" => 'staffLevelName'
        ]);
    }

    public function rules()
    {
        return [
            [["staff_code", "fullname", "phone", "address", "staff_level", "search", "status", "created_at", "updated_at", "bank_account_name", "work_day", "bank_account_number"], "safe"]
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
        $query->andFilterWhere(['like', 'fullname', $this->search])
            ->orFilterWhere(['like', 'phone', $this->search])
            ->orFilterWhere(['like', 'address', $this->search])
            ->orFilterWhere(['like', 'work_day', $this->search])
            ->orFilterWhere(['like', 'bank_account_number', $this->search])
            ->orFilterWhere(['like', 'bank_account_name', $this->search]);
        return $dataProvider;
    }
}
