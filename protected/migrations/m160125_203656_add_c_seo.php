<?php

class m160125_203656_add_c_seo extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mt_merchant','url','varchar(255) NOT NULL');
        $this->alterColumn('mt_merchant','restaurant_slug','varchar(255) NOT NULL default \'\'');

        $this->addColumn('mt_service_category','seo_title','varchar(255) NOT NULL default \'\'');
        $this->addColumn('mt_service_category','url','varchar(255) NOT NULL');
        $this->addColumn('mt_service_category','seo_description','varchar(255) NOT NULL default \'\'');
        $this->addColumn('mt_service_category','seo_keywords','varchar(255) NOT NULL default \'\'');

        $this->addColumn('mt_service_subcategory','url','varchar(255) NOT NULL');
        $this->addColumn('mt_service_subcategory','seo_title','varchar(255) NOT NULL default \'\'');
        $this->addColumn('mt_service_subcategory','seo_description','varchar(255) NOT NULL default \'\'');
        $this->addColumn('mt_service_subcategory','seo_keywords','varchar(255) NOT NULL default \'\'');
	}

	public function down()
	{
		echo "m160125_203656_add_c_seo does not support migration down.\n";
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