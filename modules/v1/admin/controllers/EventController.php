<?php

namespace app\modules\v1\admin\controllers;

use app\helpers\ResponseBuilder;
use app\modules\v1\admin\models\Event;
use app\modules\v1\admin\models\search\EventSearch;
use Yii;
use app\modules\v1\admin\models\form\EventForm;

class EventController extends Controller
{
    /**
     * @throws Yii\web\HttpException
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $eventComponent = $this->module->eventComponent;
        $check = $eventComponent->create($request->post());
        if (!$check) {
            return ResponseBuilder::responseJson($check, [
                "errors" => $eventComponent->event->getErrors()
            ]);
        };
        $eventComponent->assignCustomer();
        $eventComponent->assignStaff();
        return ResponseBuilder::responseJson(true, [
            "event" => $eventComponent->event,
            "link_target" => Yii::$app->urlManager->createAbsoluteUrl(
                ["/v1/admin/staff-event/build-pdf?event_id={$eventComponent->event->id}"]
            )
        ], "Thêm Thành Công Sự Kiện");
    }

    public function actionUpdate($id)
    {
        $event = EventForm::findOneActive($id);
        if (!$event) {
            return ResponseBuilder::responseJson(false, null, null, 404);
        }
        $request = Yii::$app->request;
        $eventComponent = $this->module->eventComponent;
        $check = $eventComponent->setEvent($event, $request->post());
        if (!$check) {
            return ResponseBuilder::responseJson($check, [
                "errors" => $eventComponent->event->getErrors()
            ]);
        };
        $eventComponent->revorkStaffAll();
        $eventComponent->revorkCustomerAll();
        $eventComponent->assignCustomer();
        $eventComponent->assignStaff();

        return ResponseBuilder::responseJson(true, [
            "event" => $eventComponent->event,
            "link_target" => Yii::$app->urlManager->createAbsoluteUrl(
                ["/v1/admin/staff-event/build-pdf?event_id={$eventComponent->event->id}"]
            )
        ], "Cập Nhật Thành Công Sự Kiện");
    }

    /**
     * @throws yii\web\HttpException
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $dataProviders = new EventSearch();
        $events = $dataProviders->search($request->queryParams);
        return ResponseBuilder::responseJson(true, $events);
    }

    public function actionView($id): array
    {
        $event = EventForm::active()->where(["id" => $id])->one();
        if (!$event) {
            return ResponseBuilder::responseJson(false, null, null, 404);
        }
        return ResponseBuilder::responseJson(true, compact("event"));
    }

    public function actionGenerateCode($date): array
    {
        $dateFormated = date("Y-m-d", strtotime($date));

        $event = EventForm::find()->where([
            "<>", "status", EventForm::STATUS_DELETE
        ])->andWhere([
            "like", "start_at", $dateFormated
        ])->one();

        if ($event) {
            return ResponseBuilder::responseJson(false, "", "Đã Có Sự Kiện $dateFormated");
        }
        return ResponseBuilder::responseJson(true, [
            "code" => "KADITA_SK_" . $dateFormated
        ]);
    }

    /**
     * @param $id
     * @param $undo
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionDelete($id, $undo = false)
    {
        $event = EventForm::find()->where(["id" => $id])->one();
        if (!$event) {
            return ResponseBuilder::responseJson(false, null, null, 404);
        }
        $event->is_deleted = $undo ? null : 1;
        $event->save(false);
        return ResponseBuilder::responseJson(true, compact("event"), "Thao tác thành công");
    }

}