<?php

class Media extends AppModel
{
	public $useTable = 'media';
    public $displayField = 'name';
	public $actsAs = array(
	       'Upload.Upload' => array(
	       'fields'=>array(
	       		'url' => 'medias/:y/:m/:basename')
	       )
	    );
}