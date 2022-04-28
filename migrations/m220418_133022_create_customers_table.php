<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customers}}`.
 */
class m220418_133022_create_customers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customers}}', [
            'id' => $this->primaryKey(),
            'customer_code' => $this->string(255)->unique()->notNull(),
            'surrogate' => $this->string(255),
            'name' => $this->string(255),
            'phone' => $this->string(255),
            'address' => $this->string(255),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->dateTime(),
            'updated' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customers}}');
    }
}
