<?php

namespace app\modules\v1\admin\models\form;

use app\modules\v1\admin\models\CustomerEvent;

class CustomerEventForm extends CustomerEvent
{

    public function rules()
    {
        return [
            [['customer'], 'each', 'exist'],
        ];
    }

}