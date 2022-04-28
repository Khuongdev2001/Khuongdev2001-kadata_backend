<?php

use yii\db\Migration;

/**
 * Class m220423_181053_update_staffs_table
 */
class m220423_181053_update_staffs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("staffs", "work_day",$this->integer());
        $this->addColumn("staffs","bank_account_name",$this->string());
        $this->addColumn("staffs","bank_account_number",$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220423_181053_update_staffs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220423_181053_update_staffs_table cannot be reverted.\n";

        return false;
    }
    */
}
