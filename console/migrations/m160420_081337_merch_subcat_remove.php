<?php

class m160420_081337_merch_subcat_remove extends CDbMigration
{
	public function up()
	{
        $this->dropColumn('mt_merchant','subcategory_id');
	}

	public function down()
	{
		echo "m160420_081337_merch_subcat_remove does not support migration down.\n";
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