<?php

class m160524_072035_order_id extends CDbMigration
{
	public function up()
	{
        $this->addColumn('order','order_id','integer(11) NOT NULL');
	}

	public function down()
	{
		echo "m160524_072035_order_id does not support migration down.\n";
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