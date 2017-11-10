<?php

class m160123_134123_table_categories extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{service_category}}',[
            'id' => 'pk',
            'title' => 'VARCHAR (255) NOT NULL',
            'description' => 'text',
            'is_active' => 'integer(1) NOT NULL DEFAULT \'1\'',
            'is_approved' => 'integer(2) NOT NULL DEFAULT \'0\'',
            'approved_text' => 'VARCHAR (500) NOT NULL DEFAULT \'\'',
            'date_created' => 'datetime NOT NUll',
            'date_updated' => 'datetime',
            'merchant_id' => 'integer(11) NOT NULL default \'0\''
        ],  'ENGINE=InnoDB CHARSET=utf8');

	}

	public function down()
	{
		echo "m160123_134123_table_categories does not support migration down.\n";
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