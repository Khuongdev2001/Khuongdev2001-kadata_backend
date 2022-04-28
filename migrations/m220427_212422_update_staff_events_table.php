<?php

use yii\db\Migration;

/**
 * Class m220427_212422_update_staff_events_table
 */
class m220427_212422_update_staff_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("staff_events", "event_id", $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220427_212422_update_staff_events_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220427_212422_update_staff_events_table cannot be reverted.\n";

        return false;
    }
    */
}
