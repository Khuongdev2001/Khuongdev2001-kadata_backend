<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%staffs}}`.
 */
class m220418_133110_create_staffs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%staffs}}', [
            'id' => $this->primaryKey(),
            'staff_code' => $this->string("255")->unique()->notNull(),
            'fullname' => $this->string(255)->notNull(),
            'phone' => $this->string(20),
            'address' => $this->string(255),
            'staff_level' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime()
        ]);
        $this->addForeignKey("fk-staffs-staff_level","staffs","staff_level","staff_levels","id","CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%staffs}}');
    }
}
