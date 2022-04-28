<?php

use yii\db\Migration;

/**
 * Class m220419_144020_update_users_table
 */
class m220419_144020_update_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("users", "password_hash", $this->string(255));
        $this->addColumn("users", "auth_key", $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220419_144020_update_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220419_144020_update_users_table cannot be reverted.\n";

        return false;
    }
    */
}
