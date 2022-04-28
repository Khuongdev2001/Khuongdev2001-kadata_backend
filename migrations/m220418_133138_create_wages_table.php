<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wages}}`.
 */
class m220418_133138_create_wages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wages}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'staff_id' => $this->integer()->notNull(),
            'basic_pay' => $this->integer(),
            'piece_pay' => $this->integer(),
            'allowance_pay' => $this->integer(),
            'total_pay' => $this->integer(),
            'status' => $this->integer(10),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey("fk-wages-customer_id", "wages", "customer_id", "customers", "id", "CASCADE");
        $this->addForeignKey("fk-wages-staff_id", "wages", "staff_Id", "staffs", "id", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wages}}');
    }
}
