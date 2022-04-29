<?php

use yii\db\Migration;

/**
 * Class m220428_074019_update_events_table
 */
class m220428_074019_update_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("events", "start_at", $this->date());
        $this->addColumn("events","is_deleted",$this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220428_074019_update_events_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220428_074019_update_events_table cannot be reverted.\n";

        return false;
    }
    */
}
