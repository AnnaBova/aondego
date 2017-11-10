<?php

class m160523_054906_types_to_order extends CDbMigration
{
	public function up()
	{
        $this->addColumn('order','is_group','integer(1) NOT NULL default \'0\'');
        $this->addColumn('order','source_type','integer(2) NOT NULL default \'0\'');
	}

	public function down()
	{
		echo "m160523_054906_types_to_order does not support migration down.\n";
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