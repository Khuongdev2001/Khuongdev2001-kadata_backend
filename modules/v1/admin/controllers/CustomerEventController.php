<?php

namespace app\modules\v1\admin\controllers;

use app\helpers\ResponseBuilder;
use Yii;
use app\modules\v1\admin\models\search\CustomerEventSearch;

class CustomerEventController extends Controller
{
    /**
     * @throws yii\web\HttpException
     */
    public function actionIndex()
    {
        $model = new CustomerEventSearch();
        $customerEvents = $model->search(Yii::$app->request->queryParams);
        return ResponseBuilder::responseJson(true, $customerEvents);
    }
}