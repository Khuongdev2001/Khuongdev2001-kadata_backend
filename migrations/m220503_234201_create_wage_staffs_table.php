<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wage_staffs}}`.
 */
class m220503_234201_create_wage_staffs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wage_staffs}}', [
            'id' => $this->primaryKey(),
            'staff_id' => $this->integer(),
            'level_text' => $this->string(),
            'level_pay' => $this->integer(),
            'turnover_pay' => $this->integer(),
            'allowance_pay' => $this->integer(),
            'total_pay' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->date(),
            'updated_at' => $this->date()
        ]);
        $this->addForeignKey("fk-staff_id-wage_staffs","wage_staffs","staff_id","staffs","id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wage_staffs}}');
    }
}
