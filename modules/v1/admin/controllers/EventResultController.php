<?php

namespace app\modules\v1\admin\controllers;

use app\helpers\ResponseBuilder;
use app\modules\v1\admin\models\Event;
use app\modules\v1\admin\models\EventResult;
use app\modules\v1\admin\models\form\EventResultForm;
use app\modules\v1\admin\models\search\EventResultSearch;
use app\modules\v1\admin\models\search\StaffSearch;
use app\modules\v1\admin\models\Staff;
use Spipu\Html2Pdf\Html2Pdf;
use Yii;

class EventResultController extends Controller
{
    /**
     * @throws yii\web\HttpException
     */
    public function actionCreate($event_id)
    {
        $model = new EventResultForm();
        $model->load(Yii::$app->request->post(), "");
        if (!$model->validate()) {
            return ResponseBuilder::responseJson(false, [
                "error" => $model->getErrors()
            ]);
        }
        $event = Event::findOneActive($event_id);
        $dateNext = strtotime(date("Y-m-d", strtotime($event->start_at))) + 24 * 3600;
        if ($dateNext > time()) {
            $model->addError("event_id", "Ngày tiếp theo ngày sắp xếp lịch mới được tạo kết quả");
            return ResponseBuilder::responseJson(false, [
                "errors" => $model->getErrors()
            ]);
        }
        $model->status = EventResultForm::STATUS_INACTIVE;
        $model->save();
        return ResponseBuilder::responseJson(true, [
            "event_result" => $model
        ], "Thêm Nhân Viên trả kết quả thành công");
    }

    /**
     * @throws yii\web\HttpException
     */
    public function actionUpdate($id)
    {
        $eventResult = EventResultForm::findOneActive($id);
        if (!$eventResult) {
            return ResponseBuilder::responseJson(false, "Không tìm thấy lịch trả kết quả sự kiện");
        }
        $eventResult->load(Yii::$app->request->post(), "");
        if (!$eventResult->validate()) {
            return ResponseBuilder::responseJson(false, [
                "errors" => $eventResult->getErrors()
            ]);
        }
        $eventResult->save();
        return ResponseBuilder::responseJson(true, [
            "event_result" => $eventResult
        ], "Cập Nhật lịch sử trả kết quả sự kiện thành công");
    }

    public function actionView($id)
    {
        $eventResult = EventResultForm::find()->where(["id" => $id])->one();
        if (!$eventResult) {
            return ResponseBuilder::responseJson(false, "Không tìm thấy lịch trả kết quả sự kiện");
        }
        return ResponseBuilder::responseJson(true, [
            "event_result" => $eventResult
        ], "Xóa thành công sự kiện");
    }

    /**
     * @param $id
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionDelete($id)
    {
        $eventResult = EventResultForm::findOneActive($id);
        if (!$eventResult) {
            return ResponseBuilder::responseJson(false, "Không tìm thấy lịch trả kết quả sự kiện");
        }
        $eventResult->status = EventResultForm::STATUS_DELETE;
        $eventResult->save(false);
        return ResponseBuilder::responseJson(true, null, "Xóa thành công sự kiện");
    }

    /**
     * @return void
     */
    public function actionDeleteMany()
    {


    }

    /**
     * @param $event_id
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionIndex($event_id): array
    {
        $event = Event::findOneActive($event_id);
        if (!$event) {
            return ResponseBuilder::responseJson(false, "Không tìm thấy sự kiện ");
        }
        $dateNext = strtotime(date("Y-m-d", strtotime($event->start_at))) + 24 * 3600;
        if ($dateNext > time()) {
            return ResponseBuilder::responseJson(false, "Ngày tiếp theo ngày sắp xếp lịch mới được tạo kết quả");
        }
        $model = new EventResultSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        return ResponseBuilder::responseJson(true, $dataProvider);
    }

    public function actionSort($event_id)
    {
        $event = Event::find()
            ->where(["id" => $event_id])
            ->andWhere(["status" => Event::STATUS_ADVISE])
            ->one();
        if (!$event) {
            return ResponseBuilder::responseJson(false, null, "Không tìm thấy sự kiện hoặc sự kiện đã sắp xếp");
        }
        $staffs = Staff::find()->where(["status" => Staff::STATUS_ACTIVE])->orderBy("work_day", "DESC")->all();
        $eventResults = EventResult::find()->where(["event_id" => $event_id])->andWhere(["<>", "status", EventResult::STATUS_DELETE])->all();
        $index = 0;
        foreach ($eventResults as $eventResult) {
            if (empty($staffs[$index])) {
                $index = 0;
            }
            $eventResult->seller_id = $staffs[$index]->id;
            $eventResult->save(false);
            $index++;
        }
        $event->status = Event::STATUS_RESULT;
        if ($event->save(false)) {
            return ResponseBuilder::responseJson(true, null, "Đã sắp xếp sự kiện");
        }
        return ResponseBuilder::responseJson(false, null, "Không thể sắp xếp sự kiện");
    }

    /**
     * @param $id
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionConfirm($id): array
    {
        $eventResult = EventResultForm::findOneActive($id);
        if (!$eventResult) {
            return ResponseBuilder::responseJson(false, null, "Không tìm thấy lịch trả kết quả sự kiện");
        }
        if (!$eventResult->seller_id) {
            return ResponseBuilder::responseJson(false, null, "Chưa sắp xếp lịch trả kết quả");
        }
        $eventResult->status = EventResultForm::STATUS_ACTIVE;
        $eventResult->paid_at = date("Y-m-d h:i:s");
        $eventResult->save(false);
        /* Wage*/
        $staff = Staff::findOne($eventResult->seller_id);
        $staff->work_day += $eventResult->turnover;
        $staff->save(false);
        return ResponseBuilder::responseJson(true, [
            "event_result" => $eventResult
        ], "Xác nhận nhân viên trên đã trả kết quả");
    }


    public function actionBuildPdf($event_id)
    {
        $event = Event::find()
            ->where(["id" => $event_id])
            ->andWhere(["status" => Event::STATUS_RESULT])
            ->one();
        if (!$event) {
            return ResponseBuilder::responseJson(false, null, "Không tìm thấy sự kiện hoặc sự kiện chưa sắp xếp");
        }
        $eventResults = EventResultSearch::find()->where([
            "event_id" => $event_id
        ])->all();
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($this->renderAjax("indexPdf",compact("eventResults","event")));
        return $html2pdf->output('myPdf.pdf');
    }
}