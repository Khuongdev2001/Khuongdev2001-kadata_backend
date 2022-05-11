<?php

namespace app\modules\v1\admin\controllers;

use app\modules\v1\admin\models\WageUpdateForm;
use Spipu\Html2Pdf\Html2Pdf;
use yii\rest\Serializer;
use app\modules\v1\admin\models\search\WageSearch;
use app\modules\v1\admin\models\Staff;
use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\models\Wage;
use app\modules\v1\admin\models\form\WageForm;

class WageStaffController extends Controller
{
    /**
     * @throws yii\web\HttpException
     */
    public function actionPay()
    {
        $prevDate = date("Y-m", strtotime("-1 month"));
        $wage = WageForm::find()->where(["like", "salaryed_at", $prevDate])->one();
        if ($wage) {
            return ResponseBuilder::responseJson(false, null, "$prevDate này đã tính lương");
        }
        $staffs = Staff::find()->where(["status" => Staff::STATUS_ACTIVE])->all();
        foreach ($staffs as $staff) {
            $model = new WageForm;
            $level = $staff->staffLevel;
            $model->staff_id = $staff->id;
            $model->basic_pay = $level->pay_level;
            $model->piece_pay = $staff->turnover * 12.5 / 100;
            $model->allowance_pay = $level->allowance_pay;
            $model->salaryed_at = $prevDate;
            $model->status = WageForm::STATUS_PENDING;
            $this->setTotalWage($model);
            $model->save(false);
            $this->resetStaff($staff);
        }
        return ResponseBuilder::responseJson(true, null, "Tính lương $prevDate thành công");
    }

    private function setTotalWage($model)
    {
        $model->total_pay = $model->basic_pay + $model->piece_pay + $model->allowance_pay;
    }

    private function resetStaff(Staff $staff)
    {
        $staff->work_day = 0;
        $staff->turnover = 0;
        $staff->save(false);
    }

    public function actionView($id)
    {
        $wage = Wage::findOne(["id" => $id]);
        return ResponseBuilder::responseJson(boolval($wage), compact("wage"));
    }

    public function actionUpdate($id)
    {
        $wage = WageUpdateForm::find()->where(["id" => $id])->andWhere(["status" => Wage::STATUS_PENDING])->one();
        if (!$wage) {
            return ResponseBuilder::responseJson(false, null, "Wage not found", 404);
        }
        $request = Yii::$app->request;
        $wage->load($request->post(), "");
        if (!$wage->validate()) {
            return ResponseBuilder::responseJson(false, [
                "errors" => $wage->getErrors()
            ]);
        }
        $this->setTotalWage($wage);
        $wage->save(false);
        return ResponseBuilder::responseJson(true, compact("wage"), "Cập nhật lương thành công");
    }

    /**
     * @throws yii\web\HttpException
     */
    public function actionIndex(): array
    {
        $model = new WageSearch();
        $querys = Yii::$app->request->queryParams;
        $querys["salaryed_at"] = $querys["salaryed_at"] ?? date("Y-m", strtotime("-1 month"));
        $serializer = new Serializer(['collectionEnvelope' => 'items']);
        $wage = $serializer->serialize($model->search($querys));
        return ResponseBuilder::responseJson(true, array_merge([
            "is_payed" => (bool)WageForm::find()->where(["like", "salaryed_at", $querys["salaryed_at"]])->one(),
            "salary_now" => $querys["salaryed_at"]
        ], $wage), "Bảng lương ");
    }

    public function actionBuildPdf($salaryed_at)
    {
        $wages = WageSearch::find()->where(["salaryed_at" => $salaryed_at])->all();
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($this->renderAjax("indexPdf", compact("wages","salaryed_at")));
        return $html2pdf->output('myPdf.pdf');
    }

}