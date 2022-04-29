<?php

namespace app\modules\v1\admin\models;

use app\models\query\base\Event as EventBase;

class Event extends EventBase
{
    static function active()
    {
        return self::find()->where(["is_deleted" => null]);
    }

    static function findOneActive($id)
    {
        return self::active()->where(["id" => $id])->one();
    }

}
