<?php

namespace app\modules\v1;

use app\modules\v1\admin\AdminModule;
use yii\base\Module;

class V1 extends Module
{
    public function init()
    {
        parent::init();
        $this->modules = [
            "admin" => AdminModule::class
        ];
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className()
        ];
        $behaviors['rateLimiter'] = [
            'class' => \yii\filters\RateLimiter::class
        ];
        return $behaviors;
    }   
}
