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
    
    function afterFind($results, $primary = false)
    {
        foreach($results as &$result)
        {
            if(!isset($result[$this->alias]['file_info']))
            {
                $result[$this->alias]['file_info'] = '{}';
            }
            $result[$this->alias]['file_info'] = json_decode($result[$this->alias]['file_info'], true);
        }
        return $results;
    }
}