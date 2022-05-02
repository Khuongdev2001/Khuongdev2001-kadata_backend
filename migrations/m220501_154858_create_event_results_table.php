<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event_results}}`.
 */
class m220501_154858_create_event_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event_results}}', [
            'id' => $this->primaryKey(),
            'consultant_id' => $this->integer()->notNull(),
            'event_id' => $this->integer(),
            'seller_id' => $this->integer(),
            'customer_id' => $this->integer(),
            'buyer_name' => $this->string(255),
            'buyer_phone' => $this->string(50),
            'turnover' => $this->integer(),
            'status' => $this->integer(),
            'paid_at' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey("fk-event_results-event_id", "event_results", "event_id", "events", "id");
        $this->addForeignKey("fk-event_results-seller_id","event_results","seller_id","staffs","id");
        $this->addForeignKey("fk-event_results-consultant_id","event_results","consultant_id","staffs","id");
        $this->addForeignKey("fk-event_results-customer_id","event_results","customer_id","customers","id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event_results}}');
    }
}
