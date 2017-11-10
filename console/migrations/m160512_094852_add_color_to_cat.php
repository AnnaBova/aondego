<?php

class m160512_094852_add_color_to_cat extends CDbMigration
{
	public function up()
	{
        $this->addColumn('category_has_merchant','color','varchar(255) NOT NULL default \'\'');
	}

	public function down()
	{
		echo "m160512_094852_add_color_to_cat does not support migration down.\n";
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