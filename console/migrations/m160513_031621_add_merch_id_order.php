<?php

class m160513_031621_add_merch_id_order extends CDbMigration
{
	public function up()
	{
        $this->addColumn('group_order','merchant_id','integer(11) NOT NULL default \'0\'');
        $this->addColumn('order','merchant_id','integer(11) NOT NULL default \'0\'');
	}

	public function down()
	{
		echo "m160513_031621_add_merch_id_order does not support migration down.\n";
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