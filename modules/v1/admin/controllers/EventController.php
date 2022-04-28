<?php

namespace app\modules\v1\admin\controllers;

use app\helpers\ResponseBuilder;
use app\models\query\StaffEvent;
use app\modules\v1\admin\models\Customer;
use app\modules\v1\admin\models\form\CustomerEventForm;
use app\modules\v1\admin\models\Staff;
use Yii;
use app\modules\v1\admin\models\form\EventForm;
use yii\web\Response;

class EventController extends Controller
{
    /**
     * @throws Yii\web\HttpException
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $eventModel = new EventForm();
        $event = $this->createEvent($eventModel, $request);
        /* Show Error */
        if (!isset($event["errors"])) {
            return $event;
        }

        $customers = $event->customer;
        $idsCustomer = [];
        $idsStaff = array_map(function ($item) {
            return $item["id"];
        }, $event->staff);
        $totalQty = 0;
        $totalStaff = count($event->staff);
        foreach ($customers as $customer) {
            $totalQty += $customer["qty"];
            $idsCustomer[] = $customer["id"];
        }

        if ($totalQty > $totalStaff) {
            return ResponseBuilder::responseJson(false, null, "Số Nhân Viên Không Đủ");
        }
        $staffs = Staff::find()->where(["status" => Staff::STATUS_ACTIVE])->andWhere([
            "in", "id", $idsStaff
        ])->orderBy(["work_day" => SORT_ASC])->all();

        $customers = Customer::find()->where(["status" => Staff::STATUS_ACTIVE])->andWhere([
            "in", "id", $idsCustomer
        ])->all();

        /* Handle Save Customer_Event */
        foreach ($customers as $customer) {
            $customerModel = new CustomerEventForm();
            $customerModel->event_id = $event->id;
            $customerModel->customer_id = $customer->id;
            $customerModel->save(false);
        }

        $qtyRequired = 0;
        $customerIndex = 0;
        $template = [];
        foreach ($staffs as $staff) {
            $qtyRequired++;
            if ($qtyRequired > $event->customer[$customerIndex]["qty"]) {
                $qtyRequired = 0;
                $customerIndex++;
                continue;
            }
            /* Handle Save Staff_Event*/
            $staffModel = new StaffEvent();
            $staffModel->event_id = $event->id;
            $staffModel->customer_id = $event->customer[$customerIndex]["id"];
            $staffModel->staff_id = $staff->id;
            $staffModel->save();
        }
        return ResponseBuilder::responseJson(true, null, "Thêm Thành Công Sự Kiện");
    }


    /**
     * @throws yii\web\HttpException
     */
    private function createEvent(EventForm $event, $request): array|EventForm
    {
        $event->load($request->post(), "");
        $event->code = uniqid();
        $event->status = 0;
        if (!$event->date_start_value) {
            $event->date_start_value = date("YY/mm/dd");
        }
        if ($event->save()) {
            return $event;
        }
        return ResponseBuilder::responseJson(false, [
            "errors" => $event->getErrors()
        ]);
    }


}