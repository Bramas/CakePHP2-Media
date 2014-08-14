<?php
App::uses('AppController', 'Controller');

class MediaController extends AppController {

	public $components = array('Upload.PluploadHandler');
	public $helpers = array('Upload.Upload');
	public $uses = array('Media.Media');

	public function admin_finder($domId = null)
	{
		$this->set('Media', $this->Media->find('all'));
		$this->layout = 'empty';
		if(!empty($domId))
		{
			$this->set('domId', $domId);
		}
	}
	public function admin_delete()
	{
		if(!$this->request->is('post'))
		{
			exit('{"success":0,"message":"has to be post"}');
		}
		$this->Media->id = $this->request->data['Media']['id'];
		unlink(ROOT.'/app/webroot'.$this->Media->field('url'));
		$this->Media->delete($this->request->data['Media']['id']);
		exit('{"success":1}');
	}
	public function admin_add()
	{
		if(empty($this->request->data))
		{
			exit('{"success":0,"message":"empty data"}');
		}
		$this->request->data['Media'] = array('name' => $this->request->data['Upload']['url']['name']);
		$this->Media->save($this->request->data);
		exit('{"success":1,"id":'.$this->Media->id.',"name":"'.$this->Media->field('name').'","url":"'.$this->Media->field('url').'"}');
		
	}

}