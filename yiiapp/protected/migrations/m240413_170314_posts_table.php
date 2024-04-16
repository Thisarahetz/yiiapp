<?php

class m240413_170314_posts_table extends CDbMigration
{
	public function up()
{
    $this->createTable('posts', array(
        'id' => 'pk',
        'title' => 'string NOT NULL',
        'content' => 'text',
        'category' => 'string',
        'tags' => 'string',
        'created_at' =>'datetime'
    ));
}

	public function down()
	{
		echo "m240413_170314_posts_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}