<?php

class m160520_163425_addtimes_to_order extends CDbMigration
{
	public function up()
	{
        $this->addColumn('order','create_time','datetime NOT NULL');
	}

	public function down()
	{
		echo "m160520_163425_addtimes_to_order does not support migration down.\n";
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