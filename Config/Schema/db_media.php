<?php
class DbMediaSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $media = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 500),
		'url' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 500),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
	    'tableParameters' => array(
	        'engine' => 'InnoDB',
	        'charset' => 'utf8',
	        'collate' => 'utf8_general_ci',
	        'encoding' => 'utf8_general_ci'
		    )
		);
			
}