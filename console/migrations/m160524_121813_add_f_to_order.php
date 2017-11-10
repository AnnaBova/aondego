<?php

class m160524_121813_add_f_to_order extends CDbMigration
{
	public function up()
	{
        $this->addColumn('order','price','float(8,2) NOT NULL  default \'0\'');
        $this->addColumn('order','more_info','varchar(511) NOT NULL  default \'\'');
     //   $this->addColumn('order','price','float(8,2) NOT NULL  default \'0\'');
	}

	public function down()
	{
		echo "m160524_121813_add_f_to_order does not support migration down.\n";
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