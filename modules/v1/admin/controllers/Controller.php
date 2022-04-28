<?php

namespace app\modules\v1\admin\controllers;

use yii\rest\Controller as BaseController;

class Controller extends BaseController
{
    public function verbs()
    {
        return [
            'index' => ['GET'],
            'update' => ['POST'],
            'view' => ['GET'],
            'delete' => ['POST', 'DELETE'],
            'delete-many' => ['POST', 'DELETE'],
            'create' => ['POST']
        ];
    }
}
