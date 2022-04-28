<?php

namespace app\modules\v1\admin\controllers;

use app\modules\v1\admin\models\search\StaffSearch;
use app\modules\v1\admin\models\Staff;
use Yii;
use app\modules\v1\admin\models\search\CustomerSearch;
use app\helpers\ResponseBuilder;
use app\models\base\Customer;
use app\modules\v1\admin\models\form\CustomerForm;
use app\models\Status;
use yii\helpers\Inflector;
use Spipu\Html2Pdf\Html2Pdf;

class CustomerController extends Controller
{
    /**
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $dataProviders = new CustomerSearch();
        $customers = $dataProviders->search($request->queryParams);
        return ResponseBuilder::responseJson(true, $customers);
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
        $customer = new CustomerForm();
        $customer->load($request->post(), "");
        $customer->customer_code = "KH_" . Inflector::slug($customer->name);
        if ($customer->validate() && $customer->save()) {
            return ResponseBuilder::responseJson(true, [
                "customer" => $customer
            ], "Thêm thành công Đối Tác");
        }
        return ResponseBuilder::responseJson(false, $customer->getErrors(), null);
    }

    /**
     * @return array
     * @throws yii\base\Exception
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\HttpException
     * @throws Exception
     * @author khuongdev2001
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $customer = CustomerForm::findOne(["id" => $id]);
        if (!$customer) {
            return ResponseBuilder::responseJson(false, null, "Customer not found by id", Status::STATUS_NOT_FOUND);
        }
        $customer->load($request->post(), "");
        $customer->customer_code = "KH_" . Inflector::slug($customer->name);
        if ($customer->validate() && $customer->save()) {
            return ResponseBuilder::responseJson(true, [
                "customer" => $customer
            ], "Cập nhật Đối Tác thành công");
        }
        return ResponseBuilder::responseJson(false, $customer->getErrors(), null);
    }

    /**
     * @return array
     * @throws yii\web\HttpException
     * @author khuongdev2001
     */
    public function actionView($id): array
    {
        $customer = CustomerForm::find()->where(["id" => $id])->andWhere(["<>", "status", "-99"])->one();
        if ($customer) {
            return ResponseBuilder::responseJson(true, [
                "customer" => $customer
            ]);
        }
        return ResponseBuilder::responseJson(false, null, "Customer not found by id", Status::STATUS_NOT_FOUND);
    }


    /**
     * @return array
     * @throws yii\web\HttpException
     * @author khuongdev2001
     */
    public function actionDelete($id): array
    {
        $request = Yii::$app->request;
        $customer = CustomerForm::findOne(["id" => $id]);
        if (!$customer) {
            return ResponseBuilder::responseJson(false, null, "Customer not found by id", Status::STATUS_NOT_FOUND);
        }
        $customer->status = intval($request->get("undo")) ?: -99;
        $customer->save(false);
        return ResponseBuilder::responseJson(true, [
            "customer" => $customer
        ], "Thao Tác Thực Hiện");
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
        $status = Customer::updateAll(["status" => "-99"], ["in", "id", $ids]);
        if ($status) {
            return ResponseBuilder::responseJson(true, "", "Delete {$status} successfully");
        }
        return ResponseBuilder::responseJson(false, null, "Can't delete customer by id", Status::STATUS_BAD_REQUEST);
    }

    /**
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     */
    public function actionBuildPdf()
    {
        $customers = CustomerSearch::find()->where(["status" => CustomerSearch::STATUS_ACTIVE])->all();
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($this->renderAjax("indexPdf", compact("customers")));
        return $html2pdf->output('myPdf.pdf');
    }
}
