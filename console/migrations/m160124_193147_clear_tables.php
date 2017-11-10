<?php

class m160124_193147_clear_tables extends CDbMigration
{
	public function up()
	{
        $this->dropColumn('mt_order_status','ip_address');
        $this->dropColumn('mt_order_status','merchant_id');
        $this->alterColumn('mt_order_status','date_modified','datetime');
	}

	public function down()
	{
		echo "m160124_193147_clear_tables does not support migration down.\n";
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