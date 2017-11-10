<?php

class m160124_185830_add_fields_admin_merchant extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mt_packages','workers_limit','integer(11) NOT NULL default \'0\'');
        $this->addColumn('mt_admin_user','is_active','integer(1) NOT NULL default \'0\'');
	}

	public function down()
	{
		echo "m160124_185830_add_fields_admin_merchant does not support migration down.\n";
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