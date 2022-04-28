<?php

namespace app\modules\v1\admin\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\models\search\StaffLevelSearch;
use app\modules\v1\admin\models\StaffLevel;
use app\modules\v1\admin\models\form\StaffLevelForm;

class StaffLevelController extends Controller
{

    /**
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $dataProviders = new StaffLevelSearch();
        $reports = $dataProviders->search($request->queryParams);
        return ResponseBuilder::responseJson(true, $reports);
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
        $staffLevel = new StaffLevelForm();
        $staffLevel->load($request->post(), "");
        if (!$staffLevel->save()) {
            return ResponseBuilder::responseJson(false, $staffLevel->getErrors(), null);
        }
        return ResponseBuilder::responseJson(true, [
            "staff_level" => $staffLevel
        ], "Thêm Cấp Bậc thành công");
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
        $staffLevel = StaffLevelForm::findOne(["id" => $id]);
        if (!$staffLevel) {
            return ResponseBuilder::responseJson(false, null, "Report not found by id", 404);
        }
        $staffLevel->load($request->post(), "");
        if (!$staffLevel->save()) {
            return ResponseBuilder::responseJson(false, $staffLevel->getErrors(), null);
        }
        return ResponseBuilder::responseJson(true, [
            "staff_level" => $staffLevel
        ], "Cập nhật Phản Hồi thành công");
    }

    /**
     * @return array
     * @throws yii\web\HttpException
     * @author khuongdev2001
     */
    public function actionView($id): array
    {
        $staffLevel = StaffLevel::find()->where(["id" => $id])->andWhere(["<>", "status", "-99"])->one();
        if ($staffLevel) {
            return ResponseBuilder::responseJson(true, [
                "staff_level" => $staffLevel
            ]);
        }
        return ResponseBuilder::responseJson(false, null, "Staff Level not found by id", 404);
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
        $staffLevel = StaffLevelForm::findOne(["id" => $id]);
        if (!$staffLevel) {
            return ResponseBuilder::responseJson(false, null, "Không tìm thấy Cấp Bậc", 404);
        }
        $staffLevel->status =  intval($request->get("undo")) ?: StaffLevelForm::STATUS_DELETE;
        if (!$staffLevel->save(false)) {
            return ResponseBuilder::responseJson(false, null, "Xóa Thất Bại", 403);
        }
        return ResponseBuilder::responseJson(true, ["staff_level" => $staffLevel], "Xóa Cấp Bậc thành công");
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
        $staffLevels = StaffLevelForm::find()->where(["in", "id", $ids]);
        StaffLevelForm::updateAll(["status" => $status], ["in", "id", $ids]);
        return ResponseBuilder::responseJson(true, [
            "staff_levels" => $staffLevels
        ], "Thao Tác đã thực hiện");
        return ResponseBuilder::responseJson(false, null, "Can't delete Staff Level by id", 403);
    }
}
