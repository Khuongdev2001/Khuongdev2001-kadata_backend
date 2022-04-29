<?php

namespace app\modules\v1\admin\components;

use app\models\base\Staff as StaffAlias;
use app\models\query\base\Event;
use app\models\query\StaffEvent;
use app\modules\v1\admin\models\CustomerEvent;
use app\modules\v1\admin\models\form\CustomerEventForm;
use app\modules\v1\admin\models\form\EventForm;

use app\modules\v1\admin\models\Staff;
use yii\base\Component;

class EventComponent extends Component
{
    public $event;
    public $customers;
    public $staffs;
    private int $totalRequirement;
    private int $countStaff;

    public function create($eventReq): bool
    {
        $event = new EventForm();
        $event->load($eventReq, "");
        $event->status = Event::STATUS_ADVISE;
        $event->start_at = $event->date_start_value;
        $this->event = $event;
        if (!$event->validate()) {
            return false;
        }
        $this->setItem();
        if ($this->totalRequirement > $this->countStaff) {
            $event->addError("total_requirement", "Tổng số yêu cầu nhiều hơn số nhân viên hiện có");
            return false;
        };
        return $event->save(false);
    }

    public function setItem()
    {
        $this->customers = $this->event->customer;
        $this->staffs = $this->event->staff;
        $this->totalRequirement = $this->getTotalRequirement();
        $this->countStaff = $this->getCountStaff();
    }


    /**
     * @param EventForm $event
     * @param $eventReq
     * @return false
     */


    public function setEvent(EventForm $event, $eventReq): bool
    {
        $event->load($eventReq, "");
        $event->start_at = $event->date_start_value;
        $this->event = $event;
        if (!$event->validate()) {
            return false;
        }
        $this->setItem();
        if ($this->totalRequirement > $this->countStaff) {
            $event->addError("total_requirement", "Tổng số yêu cầu nhiều hơn số nhân viên hiện có");
            return false;
        };
        return $event->save(false);
    }

    /**
     * @return void
     */
    public function revorkStaffAll(): void
    {
        StaffEvent::deleteAll(["event_id" => $this->event->id]);
    }

    /**
     * @return void
     */
    public function revorkCustomerAll(): void
    {
        CustomerEvent::deleteAll(["event_id" => $this->event->id]);
    }

    public function getTotalRequirement(): int
    {
        $qty = 0;
        foreach ($this->customers as $customer) {
            $qty += $customer["qty"];
        }
        return $qty;
    }

    public function getCountStaff(): int
    {
        return count($this->staffs);
    }

    /** $customer [
     *      { id, qty, name }
     * ]
     *
     * @return void
     */
    public function assignCustomer(): void
    {
        foreach ($this->customers as $customer) {
            $customerEventModel = new CustomerEventForm();
            $customerEventModel->event_id = $this->event->id;
            $customerEventModel->customer_id = $customer["id"];
            $customerEventModel->qty = $customer["qty"];
            $customerEventModel->save();
        }
    }

    /**
     * $staff [
     *   { id, name }
     * ]
     * @return void
     */
    public function assignStaff()
    {
        $qtyRequired = 0;
        $customerIndex = 0;
        $staffs = Staff::find()->where(["status" => StaffAlias::STATUS_ACTIVE])->andWhere([
            "in", "id", array_map(function ($staff) {
                return $staff["id"];
            }, $this->staffs)])->orderBy(["work_day" => SORT_ASC])->all();
        foreach ($staffs as $staff) {
            $qtyRequired++;
            if ($qtyRequired > $this->customers[$customerIndex]["qty"]) {
                $qtyRequired = 1;
                $customerIndex++;
            }
            if(!isset($this->customers[$customerIndex])){
                break;
            }
            /* Handle Save Staff_Event*/
            $staffModel = new StaffEvent();
            $staffModel->event_id = $this->event->id;
            $staffModel->customer_id = $this->customers[$customerIndex]["id"];
            $staffModel->staff_id = $staff->id;
            $staffModel->save();
        }
    }
}