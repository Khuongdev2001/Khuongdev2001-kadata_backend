<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\{User};

class UserLoginForm extends User
{
    public function fields()
    {
        return [
            "id",
            "fullname",
            "email",
            "created_at",
            "token"
        ];
    }

}