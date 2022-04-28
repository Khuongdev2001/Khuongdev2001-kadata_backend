<?php

namespace app\models\query;

use Yii;
use \app\models\query\base\Post as BasePost;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 */
class Post extends BasePost
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
