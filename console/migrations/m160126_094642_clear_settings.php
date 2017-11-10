<?php

class m160126_094642_clear_settings extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mt_option','merchant_id','integer(11) NOT NULL default \'0\'');
        $this->alterColumn('mt_option','option_value','varchar(255) NOT NULL default \'\'');
	}

	public function down()
	{
		echo "m160126_094642_clear_settings does not support migration down.\n";
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