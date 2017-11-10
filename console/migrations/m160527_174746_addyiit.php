<?php

class m160527_174746_addyiit extends CDbMigration
{
	public function up()
	{
       // $this->createTable('yii_t',['id'=>'pk','value_en'=>'varchar(255) NOT NULL','translate_de'=>'varchar(255) NOT NULL default \'\'']);
	}

	public function down()
	{
		echo "m160527_174746_addyiit does not support migration down.\n";
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