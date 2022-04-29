<?php

namespace app\modules\v1\admin\controllers;

use app\helpers\ResponseBuilder;
use app\modules\v1\admin\models\Event;
use app\modules\v1\admin\models\StaffEvent;
use Spipu\Html2Pdf\Html2Pdf;

class StaffEventController extends Controller
{
    /**
     * @throws yii\web\HttpException
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     * @throws \yii\web\HttpException
     */
    public function actionBuildPdf($event_id): array|string
    {
        $event = Event::active()->andWhere(["id" => $event_id])->one();
        if (!$event) {
            return ResponseBuilder::responseJson(false, null, "", 404);
        }
        $staffEvents = StaffEvent::find()->where(["event_id" => $event_id])->all();
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($this->renderAjax("indexPdf", compact("staffEvents", "event")));
        return $html2pdf->output('myPdf.pdf');
    }
}