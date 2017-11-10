<?php

class m160124_182442_table_user_and_package_fixes extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mt_admin_user','role','varchar(100) NOT NULL default \'\'');
        $this->alterColumn('mt_admin_user','date_modified','datetime');
        $this->alterColumn('mt_admin_user','last_login','datetime');
        $this->alterColumn('mt_admin_user','user_access','text');
        $this->alterColumn('mt_admin_user','ip_address','varchar(100) NOT NULL default \'\'');
        $this->alterColumn('mt_admin_user','lost_password_code','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_admin_user','session_token','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_admin_user','user_lang','integer(2) NOT NULL default \'0\'');

        $this->alterColumn('mt_packages','expiration','integer(11) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','description','text');
        $this->alterColumn('mt_packages','promo_price','float(14,4) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','expiration_type','integer(2) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','unlimited_post','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','post_limit','integer(11) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','sell_limit','integer(11) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','sequence','integer(11) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','status','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_packages','date_modified','datetime');
        $this->dropColumn('mt_packages','ip_address');

	}

	public function down()
	{
		echo "m160124_182442_table_user_and_package_fixes does not support migration down.\n";
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