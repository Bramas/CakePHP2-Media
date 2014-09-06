<?php

App::uses('HtmlHelper','View/Helper');

class StaticHelper extends HtmlHelper
{
	public $staticDomain = null;

	public function assetUrl($path, $options = array()) {

		$staticDomain = $this->staticDomain;
		if($staticDomain === null)
		{
			$staticDomain = Configure::read('Admin.staticDomain');
		}
		if(!empty($staticDomain) 
			&& strpos($path, '://') === false 
			&& strpos($path, '//') !== 0)
		{
			return $staticDomain.$path;
		}
		return parent::url($path, $options);
	}
}