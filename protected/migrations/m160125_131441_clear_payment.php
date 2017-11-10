<?php

class m160125_131441_clear_payment extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mt_payment_provider','status','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_payment_provider','sequence','integer(11) NOT NULL default \'0\'');


        $this->alterColumn('mt_payment_provider','payment_logo','varchar(255) NOT NULL default \'\'');


        $this->alterColumn('mt_payment_provider','date_modified','datetime');

        $this->dropColumn('mt_payment_provider','ip_address');
	}

	public function down()
	{
		echo "m160125_131441_clear_payment does not support migration down.\n";
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