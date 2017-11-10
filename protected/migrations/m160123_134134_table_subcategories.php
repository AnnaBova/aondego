<?php

class m160123_134134_table_subcategories extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{service_subcategory}}',[
            'id' => 'pk',
            'category_id' => 'integer(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'description' => 'text',
            'is_active' => 'integer(1) NOT NULL DEFAULT \'1\'',
            'is_approved' => 'integer(2) NOT NULL DEFAULT \'0\'',
            'approved_text' => 'varchar(500) NOT NULL DEFAULT \'\'',
            'date_created' => 'datetime NOT NULL',
            'date_updated' => 'datetime',
            'merchant_id' => 'integer(11) NOT NULL default 0',

        ],  'ENGINE=InnoDB CHARSET=utf8');
        $this->addForeignKey('Subcat_fk_id', 'mt_service_subcategory','category_id','mt_service_category','id','CASCADE','CASCADE');
	}

	public function down()
	{
		echo "m160123_134134_table_subcategories does not support migration down.\n";
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