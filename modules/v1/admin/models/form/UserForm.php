<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\User;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

class UserForm extends User
{
    public $password;

    public function fields()
    {
        return array_merge(parent::fields(), [
            'status_text' => 'statusText'
        ]);
    }

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            [['email', 'fullname'], 'required'],
            ['email', 'email'],
            [
                ['email'], 'unique', 'filter' => [
                '=', 'status', 1
            ]
            ],
            [['status'], 'default', 'value' => 0],
            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],
            [['status'], 'integer'],
            ['status', 'in', 'range' => [0, 1], 'allowArray' => true],
        ];
    }
}
