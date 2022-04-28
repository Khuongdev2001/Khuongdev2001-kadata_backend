<?php

namespace app\modules\v1\admin\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\models\User;
use app\modules\v1\admin\models\search\UserSearch;
use app\modules\v1\admin\models\form\UserForm;


class SiteController extends Controller
{
    /**
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $dataProviders = new UserSearch();
        $customers = $dataProviders->search($request->queryParams);
        return ResponseBuilder::responseJson(true, $customers);
    }

    /**
     * @return array
     * @throws yii\web\HttpException
     */
    public function actionView($id)
    {
        $user = User::findOne(["id" => $id]);
        if ($user) {
            return ResponseBuilder::responseJson(true, [
                "user" => $user
            ]);
        }
        return ResponseBuilder::responseJson(false, null, "User not found by id", 404);
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
        $user = new UserForm();
        $user->setScenario('create');
        $user->load($request->post(), "");
        $user->setPassword($request->post("password"));
        if (!$user->save()) {
            return ResponseBuilder::responseJson(false, $user->getErrors(), null);
        }
        if ($user->status) {
            $auth = Yii::$app->authManager;
            $auth->assign($auth->getRole("loginBackend"), $user->getId());
        }
        return ResponseBuilder::responseJson(true, [
            "user" => $user
        ], "Thêm Thành Viên thành công");
    }

    /**
     * @return array
     * @throws yii\base\Exception
     * @throws yii\base\InvalidConfigException
     * @throws yii\web\HttpException
     * @author khuongdev2001
     */
    public function actionUpdate($id): array
    {
        $request = Yii::$app->request;
        $user = UserForm::findOne(["id" => $id]);
        if (!$user) {
            return ResponseBuilder::responseJson(false, null, "User not found by id", 404);
        }
        $user->load($request->post(), "");
        if ($request->post("password")) {
            $user->setPassword($request->post("password"));
        }
        if (!$user->save()) {
            return ResponseBuilder::responseJson(false, $user->getErrors(), null);
        }
        $auth = Yii::$app->authManager;
        $auth->revokeAll($user->getId());
        if ($user->status) {
            $auth->assign($auth->getRole("loginBackend"), $user->getId());
        }
        return ResponseBuilder::responseJson(true, [
            "user" => $user
        ], "Cập nhật Thành Viên thành công");
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
        $user = UserForm::findOne(["id" => $id]);
        if (!$user) {
            return ResponseBuilder::responseJson(false, null, "Không tìm thấy Thành Viên", 404);
        }
        /** @var yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;
        // revoke all roles of user id
        $auth->revokeAll($user->getId());
        $user->status =  intval($request->get("undo")) ?: UserForm::STATUS_DELETED;
        if (!$user->save(false)) {
            return ResponseBuilder::responseJson(false, null, "Xóa Thất Bại", 403);
        }
        return ResponseBuilder::responseJson(true, ["user" => $user], "Xóa Thành Viên thành công");
    }
}
