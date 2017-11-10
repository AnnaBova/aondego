<?php

class m160125_105153_clear_page_custom extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mt_custom_page','status','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_custom_page','open_new_tab','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_custom_page','is_custom_link','integer(1) NOT NULL default \'0\'');
        $this->alterColumn('mt_custom_page','sequence','integer(11) NOT NULL default \'0\'');

        $this->alterColumn('mt_custom_page','slug_name','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_custom_page','meta_description','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_custom_page','meta_keywords','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_custom_page','icons','varchar(255) NOT NULL default \'\'');
        $this->alterColumn('mt_custom_page','assign_to','varchar(50) NOT NULL default \'\'');

        $this->alterColumn('mt_custom_page','date_modified','datetime');

        $this->alterColumn('mt_custom_page','content','text');
        $this->dropColumn('mt_custom_page','ip_address');
	}

	public function down()
	{
		echo "m160125_105153_clear_page_custom does not support migration down.\n";
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