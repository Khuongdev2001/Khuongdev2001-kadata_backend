<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%staff_events}}`.
 */
class m220427_133959_create_staff_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%staff_events}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'staff_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey("fk-staff_events-customer_id","staff_events","customer_id","customers","id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%staff_events}}');
    }
}
