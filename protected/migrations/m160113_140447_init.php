<?php

class m160113_140447_init extends CDbMigration
{
	public function up()
	{
        echo 'test';
	}

	public function down()
	{
		echo "m160113_140447_init does not support migration down.\n";
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