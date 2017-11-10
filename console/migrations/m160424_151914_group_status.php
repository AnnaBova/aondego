<?php

class m160424_151914_group_status extends CDbMigration
{
	public function up()
	{
        $this->addColumn('group_order','status_id','integer(3) NOT NULL default \'0\'');
	}

	public function down()
	{
		echo "m160424_151914_group_status does not support migration down.\n";
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