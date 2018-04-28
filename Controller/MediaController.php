<?php
App::uses('AppController', 'Controller');
App::uses('WideImage', 'Media.Lib/WideImage');

class MediaController extends AppController {

	public $components = array('Upload.PluploadHandler');
	public $helpers = array('Upload.Upload');
	public $uses = array('Media.Media');

	public function admin_finder($domId = null)
	{
		$this->layout = 'empty';
		if(!empty($this->request->params['named']['layout']))
		{
			$this->layout = $this->request->params['named']['layout'];
		}
		$this->set('Media', $this->Media->find('all', array('order' => array('Media.name ASC'))));
		if(!empty($domId))
		{
			$this->set('domId', $domId);
		}
	}
	public function admin_edit_image($id)
	{
		$this->layout = 'empty';
		if(!empty($this->request->params['named']['layout']))
		{
			$this->layout = $this->request->params['named']['layout'];
		}

        $image = $this->Media->findById($id);
        if(empty($image))
        {
            exit('Erreur');
        }
		$this->set('image', $image);
	}
	public function admin_delete()
	{
		if(!$this->request->is('post'))
		{
			exit('{"success":0,"message":"has to be post"}');
		}
		$this->Media->id = $this->request->data['Media']['id'];
        clean_thumbs($this->Media->field('url'));
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
	public function admin_crop($id, $x, $y, $width, $height)
	{
        $image = $this->Media->findById($id);
        if(empty($image))
        {
            exit('{"success":0, "error":1, "message":"id does not exists"}');
        }
        if(!file_exists(WWW_ROOT.$image['Media']['url']))
        {
            exit('{"success":0, "error":1, "message":"file does not exists"}');
        }
        WideImage::load(WWW_ROOT.$image['Media']['url'])->crop($x, $y, $width, $height)->saveToFile(WWW_ROOT.$image['Media']['url']);
        $this->Media->clean_thumbs($image['Media']['url']);
        exit('{"success":1}');
    }
	public function serve($year, $month, $name)
	{
			preg_match('/^(.*)\.([^.]+)_([^_]*)$/', $name, $matches);
			//debug($matches);
			header("Content-type:image/".$matches[2]);
			header("Cache-Control: public, max-age=31536000");
			header("Expires: ".date('r',time()+31536000)); // set expiration time
      readfile (APP.'webroot/medias/'.$year.'/'.$month.'/'.$matches[1].'.'.$matches[2]);
			exit();
  }
}
