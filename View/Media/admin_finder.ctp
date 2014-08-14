<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">
    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
  </button>
  <h4 class="modal-title" id="myModalLabel">Mes Documents</h4>
</div>
<div class="modal-body">
<div class="media-items">
<?php
$Media[] = array('Media' => array('id'=>'','url' => 'empty','name' => 'empty'));
foreach($Media as $media):
  $media = $media['Media'];
  ?>
<div data-media-url="<?php echo $media['url']; ?>" class="media-item<?php echo $media['url']=='empty'?' media-empty':''; ?>">
  <div class="media-name">
    <?php echo $media['name']; ?>
  </div>
  <div class="media-delete">
    Supprimer
    <?php echo $this->Form->create('Media');
      echo $this->Form->input('id', array('class'=>'media-item-input-id','type'=>'hidden', 'value'=>$media['id']));
        echo $this->Form->end(); ?>
  </div>
  <div class="media-icon">
    <?php echo $this->Html->image($media['url'], array('height' => 50)); ?>
  </div>
</div>
<?php
endforeach;
?>
</div>
<div class="clear"></div>
<?php
  echo '<h2>Ajouter un media</h2>';
  echo $this->Form->create('Media', array('class'=>'media-add'));
  $this->Upload->setModel('Media');
  echo $this->Upload->input('url', array(
    'type' => 'file', 
    'label'=>'Nouveau media', 
    'multiple' => true,
    'onFileUploaded'=>"$('form.media-add').submit();"));
  echo $this->Form->end('Ajouter');
?>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
  <button type="button" class="btn btn-primary btn-disabled">Choisir</button>
</div>
<script type="text/javascript">
  jQuery(function($){

    $('form.media-add').on('submit',function(e){
        e.preventDefault();
        var postData = $(this).serializeArray();
        $.ajax({
          url : '<?php echo $this->Html->url('/media/add') ?>',
          type: "POST",
          dataType:'json',
          data : postData,
          success:function(data)
          {
            if(data.success)
            {
              var m = $('.media-items .media-item.media-empty').clone();
              m.find('.media-name').html(data.name);
              m.attr('data-media-url', data.url);
              m.find('.media-icon img').attr('src', BaseUrl+data.url);
              m.find('.media-delete .media-item-input-id').val(data.id);
              m.removeClass('media-empty');
              $('.media-items').append(m);
              $('#upload-container-url img').remove();
            }
          },
          error: function(jqXHR, textStatus, errorThrown) 
          {
              //if fails      
          }
        })
      });

      $('.media-items').on('click', '.media-item', function()
      {
          $(this).toggleClass('selected');
      });

      $('.media-items').on('click', '.media-delete', function()
      {
          var item = $(this).parent();
          item.addClass('loading');
          var postData = $(this).find('form').serializeArray();
          $.ajax({
            url:BaseUrl+'media/delete/',
            data:postData,
            context:{
              item:item
            },
            type: "POST",
            dataType:'json',
            success:function(data){
              this.item.remove();
            }
          });
      });

      $('.modal-footer .btn-primary').on('click', function(){
        $('.media-item.selected').each(function(){
          $('#<?php echo $domId; ?>').val($(this).attr('data-media-url'));
          $('#media-<?php echo $domId; ?> .media-placeholder').html('<img src="'+BaseUrl+$(this).attr('data-media-url')+'" height="50" />');
        });
        $('#<?php echo $domId; ?>-finder  .media-modal-finder').modal('hide');
      });
  });
</script> 
<?php 
echo $this->Html->css('Media.style.css'); ?>