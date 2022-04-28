<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%staff_levels}}`.
 */
class m220418_133059_create_staff_levels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%staff_levels}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'pay_level' => $this->integer(),
            'allowance_pay' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%staff_levels}}');
    }
}
