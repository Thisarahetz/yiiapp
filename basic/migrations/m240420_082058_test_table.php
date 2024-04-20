<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m240420_082058_test_table
 */
class m240420_082058_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("user", [
            "id" => Schema::TYPE_PK,
            "name" => Schema::TYPE_STRING,
            "email" => Schema::TYPE_STRING,
         ]);
         $this->batchInsert("user", ["name", "email"], [
            ["User1", "user1@gmail.com"],
            ["User2", "user2@gmail.com"],
            ["User3", "user3@gmail.com"],
            ["User4", "user4@gmail.com"],
            ["User5", "user5@gmail.com"],
            ["User6", "user6@gmail.com"],
            ["User7", "user7@gmail.com"],
            ["User8", "user8@gmail.com"],
            ["User9", "user9@gmail.com"],
            ["User10", "user10@gmail.com"],
            ["User11", "user11@gmail.com"],
         ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240420_082058_test_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240420_082058_test_table cannot be reverted.\n";

        return false;
    }
    */
}
