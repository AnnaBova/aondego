<?php

class m160125_083714_voucher_changing extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mt_voucher_new','status','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_voucher_new','used_once','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_voucher_new','voucher_owner','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_voucher_new','merchant_id','integer(11) NOT NULL default \'0\'');
        $this->alterColumn('mt_voucher_new','date_modified','datetime');
        $this->alterColumn('mt_voucher_new','expiration','date');
        $this->alterColumn('mt_voucher_new','joining_merchant','text');

        $this->dropColumn('mt_voucher_new','ip_address');
	}

	public function down()
	{
		echo "m160125_083714_voucher_changing does not support migration down.\n";
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