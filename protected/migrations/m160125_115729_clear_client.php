<?php

class m160125_115729_clear_client extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mt_client','status','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_client','mobile_verification_code','integer(11) NOT NULL default \'0\'');

        $this->alterColumn('mt_client','social_strategy','varchar(100) NOT NULL default \'\'');
        $this->alterColumn('mt_client','password','varchar(100) NOT NULL default \'\'');
        $this->alterColumn('mt_client','street','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_client','city','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_client','state','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_client','token','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_client','custom_field1','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_client','custom_field2','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_client','lost_password_token','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_client','zipcode','varchar(100) NOT NULL default \'\'');
        $this->alterColumn('mt_client','country_code','varchar(3) NOT NULL default \'\'');
        $this->alterColumn('mt_client','ip_address','varchar(50) NOT NULL default \'\'');


        $this->alterColumn('mt_client','date_modified','datetime');
        $this->alterColumn('mt_client','mobile_verification_date','datetime');
        $this->alterColumn('mt_client','last_login','datetime');
        $this->alterColumn('mt_client','location_name','text');
	}

	public function down()
	{
		echo "m160125_115729_clear_client does not support migration down.\n";
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