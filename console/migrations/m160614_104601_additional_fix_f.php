<?php

class m160614_104601_additional_fix_f extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mt_merchant','is_purchase','integer(1) NOT NULL default \'0\'');
        $this->addColumn('mt_merchant','description','text');
        $this->addColumn('category_has_merchant','description','text');
	}

	public function down()
	{
		echo "m160614_104601_additional_fix_f does not support migration down.\n";
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