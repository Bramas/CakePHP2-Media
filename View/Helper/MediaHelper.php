<?php

App::uses('AppHelper', 'View/Helper');

class MediaHelper extends AppHelper {

    public $helpers = array('Form', 'Html');

    private $_initiated = false;
    private $_finderUrl = '/media/finder';
    private $_model     = null;
    public function init()
    {
        if($this->_initiated)
        {
            return;
        }
        $this->_initiated = true;
        ?>
<script type="text/javascript">
jQuery(function($){

    $('.media .media-openfinder').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo $this->finderUrl(); ?>/'+$(this).attr('data-media-domid'),
            context:{
                domId: $(this).attr('data-media-domid')
            },
            success:function(data)
            {
                if($('#'+this.domId+'-finder .media-modal-finder').length == 0)
                {
                    var m = '<div id="'+this.domId+'-finder"><div class="modal fade media-modal-finder" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"></div></div></div></div>';

                    $('body').append(m);
                    $('#'+this.domId+'-finder .media-modal-finder .modal-content').html(data);
                }
                $('#'+this.domId+'-finder .media-modal-finder').modal();
            }
        });
    });

});
</script>
    <?php
    }

    public function finderUrl($params=null)
    {
        $url = $this->_finderUrl;
        /*if(!empty($params))
        {
            $url = array_merge($url, $params);
        }*/
        return $this->Html->url($url,true);
    }
    public function setModel($model)
    {
        $this->_model = $model;
    }
    public function image($name, $options=array())
    {
        /*
        if(empty($this->_model))
        {
            throw new Exception("You have to set model: setModel(modelname);");
        }*/
        $namePath = explode('.', $name);
        $options = array_merge(array('label' => end($namePath)), (array)$options);

        if(count($namePath) < 2 || count($namePath) > 3)
        {
            throw new Exception("name has to be of the form Model.name or Model.group.name");
        }
        $data = null;
        if(!empty($this->request->data[$namePath[0]]))
        {
            if(!empty($this->request->data[$namePath[0]][$namePath[1]]))
            {
                if(count($namePath) == 2)
                {
                    $data = $this->request->data[$namePath[0]][$namePath[1]];
                }
                elseif(!empty($this->request->data[$namePath[0]][$namePath[1]][$namePath[2]]))
                {
                    $data = $this->request->data[$namePath[0]][$namePath[1]][$namePath[2]];
                }
            }
        }
        $placeholder = '';
        $value = '';
        if(!empty($data))
        {
            $placeholder = $this->Html->image($data, array('height'=>50));
            $value= $data;
        }
        ob_start();
        $this->init();
        $id = $this->Form->domId($name);
        echo '<div class="form-group"><label for="MenuParams">'.$options['label'].'</label>';
        echo '<div class="media" id="media-'.$id.'"><div class="media-placeholder">'.$placeholder.'</div>';
        echo '<a data-media-domid="'.$id.'" class="media-openfinder" href="#">Choisir une image</a>';
        echo $this->Form->input($name, array('type'=>'hidden', 'class' => 'media-input-placeholder')).'</div></div>';

        return ob_end_flush();
    }
}