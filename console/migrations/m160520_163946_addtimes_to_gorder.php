<?php

class m160520_163946_addtimes_to_gorder extends CDbMigration
{
	public function up()
	{
        $this->addColumn('group_order','create_time','datetime NOT NULL');
	}

	public function down()
	{
		echo "m160520_163946_addtimes_to_gorder does not support migration down.\n";
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