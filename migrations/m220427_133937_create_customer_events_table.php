<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customers}}`.
 */
class m220427_133937_create_customer_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_events}}', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'customer_id' => $this->integer(),
            'qty' => $this->integer()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->addForeignKey("fk-customers_events-event_id","customer_events","event_id","events","id");
        $this->addForeignKey("fk-customers_events-customer_id","customer_events","customer_id","customers","id");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customers}}');
    }
}
