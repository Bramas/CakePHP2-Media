<?php

App::uses('HtmlHelper','View/Helper');

class StaticHelper extends HtmlHelper
{
	public $staticDomain = null;

	public function assetUrl($path, $options = array()) {

		$staticDomain = $this->staticDomain;
			echo Configure::read('Admin.staticDomain');
		if($staticDomain === null)
		{
			echo Configure::read('Admin.staticDomain');
			$staticDomain = Configure::read('Admin.staticDomain');
		}
		if(!empty($staticDomain) 
			&& strpos($path, '://') === false 
			&& strpos($path, '//') !== 0)
		{
			return $staticDomain.parent::assetUrl($path, $options);
		}
		return parent::url($path, $options);
	}
}