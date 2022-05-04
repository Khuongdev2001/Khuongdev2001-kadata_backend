<?php

namespace app\modules\v1\admin\controllers;

use app\modules\v1\admin\models\WageStaff;

class WageStaffController extends Controller
{
    public function actionPay()
    {
        $firstDayinMonthNext = date('M Y', strtotime('+1 months'));
        return $firstDayinMonthNext;
    }

    public function actionUpdate()
    {

    }

    public function actionIndex()
    {

    }

    private function handleTotalWage()
    {
        // phụ cấp + ds x 12.5% + lương cơ bản
    }


}