<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\query\base;

use Yii;

/**
 * This is the base-model class for table "events".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $status
 * @property integer $create_by
 * @property string $created_at
 * @property string $updated_at
 * @property string start_at
 * @property boolean is_deleted
 *
 * @property \app\models\query\CustomerEvent[] $customerEvents
 * @property string $aliasModel
 */
abstract class Event extends \yii\db\ActiveRecord
{
    const STATUS_ADVISE = 0;
    const STATUS_RESULT = 1;
    const STATUS_DELETE = -99;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['status', 'create_by', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at', 'start_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'status' => 'Status',
            'create_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerEvents()
    {
        return $this->hasMany(\app\models\query\CustomerEvent::className(), ['event_id' => 'id']);
    }

    public function getStaffEvents()
    {
        return $this->hasMany(\app\models\query\Staff::className(), ['id' => 'staff_id'])
            ->where(["status" => 1])
            ->viaTable("staff_events", ["event_id" => "id"]);
    }

    public function getCountCustomerAssign()
    {
        return $this->hasMany(\app\models\query\CustomerEvent::className(), ["event_id" => "id"])->count();
    }


    public function getCountStaffAssign()
    {
        return $this->hasMany(\app\models\query\StaffEvent::className(), ["event_id" => "id"])->count();
    }

    /**
     * @inheritdoc
     * @return \app\models\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\EventQuery(get_called_class());
    }


}
