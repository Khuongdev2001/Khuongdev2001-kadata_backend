<?php

namespace app\modules\v1\admin\controllers;

use Spipu\Html2Pdf\Exception\Html2PdfException;
use Yii;
use app\modules\v1\admin\models\form\StaffForm;
use app\modules\v1\admin\models\search\StaffSearch;
use app\modules\v1\admin\models\Staff;
use app\helpers\ResponseBuilder;
use Spipu\Html2Pdf\Html2Pdf;

class StaffController extends Controller
{

    /**
     * @return array
     * @throws yii\base\Exception
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\HttpException
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $request = Yii::$app->request;
        $staff = new StaffForm();
        $staff->load($request->post(), "");
        $staff->staff_code = "NV_" . uniqid();
        $staff->work_day = 0;
        if (!$staff->save()) {
            return ResponseBuilder::responseJson(false, $staff->getErrors(), null);
        }
        return ResponseBuilder::responseJson(true, [
            "staff" => $staff
        ], "Thêm Nhân Viên thành công");
    }

    /**
     * @param $id
     * @return array
     * @throws yii\web\HttpException
     * @author khuongdev2001
     */

    public function actionUpdate($id): array
    {
        $request = Yii::$app->request;
        $staff = StaffForm::findOne(["id" => $id]);
        if (!$staff) {
            return ResponseBuilder::responseJson(false, null, "Staff not found by id", 404);
        }
        $staff->load($request->post(), "");
        if (!$staff->save()) {
            return ResponseBuilder::responseJson(false, $staff->getErrors(), null);
        }
        return ResponseBuilder::responseJson(true, [
            "staff" => $staff
        ], "Cập nhật Nhân Viên thành công");
    }

    /**
     * @return array
     * @throws yii\base\Exception
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\HttpException
     * @throws Exception
     * @author khuongdev2001
     */

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $dataProviders = new StaffSearch();
        $staff = $dataProviders->search($request->queryParams);
        return ResponseBuilder::responseJson(true, $staff);
    }

    /**
     * @return array
     * @throws yii\web\HttpException
     * @author khuongdev2001
     */
    public function actionView($id)
    {
        $staff = Staff::find()->where(["id" => $id])->andWhere(["<>", "status", "-99"])->one();
        if ($staff) {
            return ResponseBuilder::responseJson(true, [
                "staff" => $staff
            ]);
        }
        return ResponseBuilder::responseJson(false, null, "Staff not found by id", 404);
    }

    /**
     * @param $id
     * @return array
     * @throws \yii\web\HttpException
     * @author khuongdev2001
     */
    public function actionDelete($id): array
    {
        $request = Yii::$app->request;
        $staff = StaffForm::findOne(["id" => $id]);
        if (!$staff) {
            return ResponseBuilder::responseJson(false, null, "Không tìm thấy Cấp Bậc", 404);
        }
        $staff->status =  intval($request->get("undo")) ?: StaffForm::STATUS_DELETE;
        if (!$staff->save(false)) {
            return ResponseBuilder::responseJson(false, null, "Xóa Nhân Viên thành công", 403);
        }
        return ResponseBuilder::responseJson(true, ["staff" => $staff], "Xóa Thành Viên thành công");
    }


    /**
     * @return array
     * @throws yii\web\HttpException
     * @author khuongdev2001
     * Here is method delete many customer
     */
    public function actionDeleteMany(): array
    {
        $request = Yii::$app->request;
        $ids = explode(",", $request->post("ids", ","));
        $status = intval($request->get("undo")) ?: -99;
        $staff = StaffForm::find()->where(["in", "id", $ids]);
        StaffForm::updateAll(["status" => $status], ["in", "id", $ids]);
        return ResponseBuilder::responseJson(true, [
            "staff" => $staff
        ], "Thao Tác đã thực hiện");
        return ResponseBuilder::responseJson(false, null, "Can't delete Staff by id", 403);
    }

    /**
     * @throws Html2PdfException
     */
    public function actionBuildPdf()
    {
        $staffs = StaffSearch::find()->where(["status" => Staff::STATUS_ACTIVE])->all();
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($this->renderAjax("indexPdf",compact("staffs")));
        return $html2pdf->output('myPdf.pdf');
    }

    
}
