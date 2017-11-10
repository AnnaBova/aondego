<?php

class m160125_174548_clear_and_add_merchant extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mt_merchant','status','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_merchant','is_commission','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_merchant','payment_steps','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_merchant','is_featured','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_merchant','user_lang','integer(11) NOT NULL default \'0\'');
$this->alterColumn('mt_merchant','sort_featured','integer(11) NOT NULL default \'0\'');

        $this->alterColumn('mt_merchant','is_ready','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_merchant','is_sponsored','integer(2) NOT NULL default \'0\'');
        $this->alterColumn('mt_merchant','free_delivery','integer(1) NOT NULL default \'0\'');
$this->alterColumn('mt_merchant','package_price','float(11.2) NOT NULL default \'0\'');

$this->alterColumn('mt_merchant','percent_commision','float(11.2) NOT NULL default \'0\'');


        $this->alterColumn('mt_merchant','country_code','varchar(3) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','service','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','abn','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','session_token','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','delivery_estimation','varchar(100) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','username','varchar(100) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','password','varchar(100) NOT NULL default \'\'');
$this->alterColumn('mt_merchant','activation_token','varchar(100) NOT NULL default \'\'');

 $this->alterColumn('mt_merchant','activation_key','varchar(50) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','ip_address','varchar(50) NOT NULL default \'\'');
        $this->alterColumn('mt_merchant','lost_password_code','varchar(50) NOT NULL default \'\'');
 $this->alterColumn('mt_merchant','commision_type','varchar(50) NOT NULL default \'\'');





        $this->alterColumn('mt_merchant','date_modified','datetime');
        $this->alterColumn('mt_merchant','membership_expired','date');
        $this->alterColumn('mt_merchant','membership_purchase_date','date');
        $this->alterColumn('mt_merchant','sponsored_expiration','date');
        $this->alterColumn('mt_merchant','date_activated','datetime');
        $this->alterColumn('mt_merchant','last_login','datetime');
        $this->alterColumn('mt_merchant','cuisine','text');

        $this->addColumn('mt_merchant','subcategory_id','integer(11) NOT NULL default \'0\'');
        $this->addColumn('mt_merchant','seo_title','varchar(255) NOT NULL default \'\'');
        $this->addColumn('mt_merchant','seo_description','varchar(255) NOT NULL default \'\'');
        $this->addColumn('mt_merchant','seo_keywords','varchar(255) NOT NULL default \'\'');
	}

	public function down()
	{
		echo "m160125_174548_clear_and_add_merchant does not support migration down.\n";
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