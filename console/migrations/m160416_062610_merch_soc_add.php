<?php

class m160416_062610_merch_soc_add extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mt_merchant','vk','varchar(255) NOT NULL default \'\'');
        $this->addColumn('mt_merchant','pr','varchar(255) NOT NULL default \'\'');
	}

	public function down()
	{
		echo "m160416_062610_merch_soc_add does not support migration down.\n";
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