<?php

namespace app\modules\v1\admin\controllers;

use Yii;
use app\modules\v1\admin\models\search\ReportSearch;
use app\modules\v1\admin\models\Report;
use app\modules\v1\admin\models\form\ReportForm;
use app\helpers\ResponseBuilder;

class ReportController extends Controller
{
    /**
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $dataProviders = new ReportSearch();
        $reports = $dataProviders->search($request->queryParams);
        return ResponseBuilder::responseJson(true, $reports);
    }

    /**
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionView($id)
    {
        $report = ReportSearch::findOne(["id" => $id]);
        if ($report) {
            return ResponseBuilder::responseJson(true, [
                "report" => $report
            ]);
        }
        return ResponseBuilder::responseJson(false, null, "Report not found by id", 404);
    }

    /**
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionDone($id)
    {
        $report = ReportForm::findOne(["id" => $id]);
        if ($report) {
            $report->status = 1;
            $report->done_at = date("Y-m-d h:i:s");
            $report->save(false);
            return ResponseBuilder::responseJson(true, [
                "report" => $report
            ], "Đã xử lý phản hồi này");
        }
        return ResponseBuilder::responseJson(false, null, "Report not found by id", 404);
    }

    /**
     * @return array
     * @throws yii\base\Exception
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\HttpException
     * @throws Exception
     * @author khuongdev2001
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $report = new ReportForm();
        $report->load($request->post(), "");
        if (!$report->save()) {
            return ResponseBuilder::responseJson(false, $report->getErrors(), null);
        }
        return ResponseBuilder::responseJson(true, [
            "report" => $report
        ], "Thêm Phản Hồi thành công");
    }

    /**
     * @param $id s
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\HttpException
     * @throws Exception
     * @author khuongdev2001
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $report = ReportForm::findOne(["id" => $id]);
        if (!$report) {
            return ResponseBuilder::responseJson(false, null, "Report not found by id", 404);
        }
        $report->load($request->post(), "");
        if (!$report->save()) {
            return ResponseBuilder::responseJson(false, $report->getErrors(), null);
        }
        return ResponseBuilder::responseJson(true, [
            "report" => $report
        ], "Cập nhật Phản Hồi thành công");
    }

    /**
     * @return array
     * @throws yii\db\StaleObjectException
     * @throws yii\web\HttpException
     * @author khuongdev2001
     */
    public function actionDelete($id): array
    {
        $request = Yii::$app->request;
        $report = Report::findOne(["id" => $id]);
        if (!$report) {
            return ResponseBuilder::responseJson(false, null, "Không tìm thấy Phản Hồi", 404);
        }
        $report->status =  intval($request->get("undo")) ?: Report::STATUS_DELETE;
        if (!$report->save(false)) {
            return ResponseBuilder::responseJson(false, null, "Xóa Thất Bại", 403);
        }
        return ResponseBuilder::responseJson(true, ["report" => $report], "Xóa Phản Hồi thành công");
    }
}
