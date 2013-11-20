<?php

class m131120_145738_add_storecategoryattribute extends CDbMigration
{
	public function up()
	{
        $this->createTable('storecategoryattribute', array(
            'category_id' => 'INT(11) NOT NULL',
            'attribute_id' => 'INT(11) NOT NULL',
            'PRIMARY KEY (`category_id`,`attribute_id`)',
        ), 'ENGINE=MYISAM DEFAULT CHARSET=utf8'); 
	}

	public function down()
	{
		echo "m131120_145738_add_storecategoryattribute does not support migration down.\n";
		return false;
	}

}