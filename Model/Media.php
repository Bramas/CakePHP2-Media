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
    
    function clean_thumbs($url)
    {
        $url = WWW_ROOT.'/thumbs'.$url;
        $simpleUrl = preg_replace('/(\.[a-zA-Z0-9]{1,10})$/', '_*', $url); 
        foreach (glob($simpleUrl) as $l)
        {
            if (preg_match("/_[0-9]{1,4}x[0-9]{1,4}.[a-zA-Z0-9]{1,10}/", $l))
            {
                unlink($l);
            }
        }
    }
}