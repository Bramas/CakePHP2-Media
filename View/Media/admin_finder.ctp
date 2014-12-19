<?php
$this->start('title');
echo 'Mes Documents';
$this->end();

?><div class="media-items media-display-grid">
<?php
$Media[] = array('Media' => array('id'=>false,'url' => 'empty','name' => 'empty', 'created'=>'0'));
foreach($Media as $media):
  $media = $media['Media'];

  $fileExplode = explode('.', $media['url']);
  if(empty($fileExplode))
  {
    $ext = '';
  }
  else
  {
    $ext = strtolower(end($fileExplode));
  }
  if(in_array($ext, array('jpg', 'jpeg', 'gif', 'bmp', 'png')))
  {
    $ext = 'img';
  }else
  if(in_array($ext, array('pdf','doc','docx', 'ods', 'odf')))
  {
     $ext = 'doc';
  }else
  if(in_array($ext, array('exe', 'dmg')))
  {
     $ext = 'exe';
  }else
  {
      $ext = 'other';
  }
 $info  ="";
  if(!empty($media['file_info']['dimensions']))
  {
    $info .= 'data-media-dimensions="'.$media['file_info']['dimensions'].'"'; 
  }
  if(!empty($media['file_info']['size']))
  {
    $info .= 'data-media-size="'.$media['file_info']['size'].'"'; 
  }
    
  ?>
<div <?php echo $info; ?> data-media-ext="<?php echo $ext; ?>" data-media-created="<?php echo $media['created']; ?>" data-media-name="<?php echo $media['name']; ?>" data-media-url="<?php echo $media['url']; ?>" class="media-item<?php echo $media['url']=='empty'?' media-empty':' media-item-'. $media['id']; ?>">
  <div class="media-icon">
    <?php 
    if($ext == "img")
    {
      echo $this->Html->image($media['url'].'_110x110', array()); 
    }
    else
    {
      echo $this->Html->image('/media/img/file.png', array()); 
    }
    

    ?>
  </div>
  <div class="media-name">
    <?php echo $media['name']; ?>
  </div>
  <div class="media-delete">
      <a href="#">Supprimer</a>
    <?php echo $this->Form->create('Media');
      echo $this->Form->input('id', array('class'=>'media-item-input-id','type'=>'hidden', 'value'=>$media['id']));
        echo $this->Form->end(); ?>
  </div>
</div>
<?php
endforeach;
?>
</div>
<div class="clear"></div>


<div class="media-file-info">
</div>


<div class="media-display-preferences">
    <div class="btn-group media-display-preference-group media-display-preference-display" role="group">
        <div class="btn btn-default media-display-preferences-item selected fa fa-th" data-media-preference-type="show-grid">
        </div>
        <div class="btn btn-default media-display-preferences-item fa fa-list" data-media-preference-type="show-list">
        </div>
    </div>
    <div class="btn-group media-display-preference-group media-display-preference-order" role="group">
        Trié par : 
        <select class="media-display-preference-order-select">
                <option value="name">Nom</option>
                <option value="created">Date</option>
        </select>
    </div>
    <div class="btn-group media-display-preference-group media-display-preference-type" role="group">
        Type de fichier : 
        <select class="media-display-preference-type-select">
                <option value="all">Tous</option>
                <option value="img">Images</option>
                <option value="doc">Documents</option>
                <option value="exe">Exécutables</option>
                <option value="other">Autres</option>
        </select>
    </div>
</div>


<?php
  echo '<h2>Ajouter un media</h2>';
  echo $this->Form->create('Media', array('class'=>'media-add'));
  $this->Upload->setModel('Media');
  echo $this->Upload->input('url', array(
    'type' => 'file', 
    'label'=>'Nouveau media', 
    'multiple' => true,
    'onFileUploaded'=>"$('form.media-add').submit();"));
  echo $this->Form->end();
?>
<script type="text/javascript">
  jQuery(function($){
      
      
function bytesToSize(bytes) {
   if(bytes == 0) return '0 Byte';
   var k = 1000;
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
   var i = Math.floor(Math.log(bytes) / Math.log(k));
   return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
}
      

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
              m.attr('data-media-name', data.name); 
              var fileExploded = data.url.toLowerCase().split('.');
              var imgExt = ['jpg','jpeg','gif','bmp','png'];
              if(fileExploded.length && imgExt.indexOf(fileExploded.slice(-1)[0].toLowerCase()) != -1)
              {
                m.find('.media-icon img').attr('src', BaseUrl+data.url+'_110x110');
                m.attr('data-media-ext', 'img');
              }
              
              m.find('.media-delete .media-item-input-id').val(data.id);
              m.removeClass('media-empty');
              m.addClass('media-item-'+data.id);
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

    $('.media-display-preference-type-select').change(function()
    {
        if($(this).val() == 'all')
        {
            $('.media-item').show();
            $('.media-empty').hide();
            return;   
        }
        $('.media-item').hide();
        $('.media-item[data-media-ext='+$(this).val()+']').show();
        $('.media-empty').hide();
    });

    $('.media-display-preference-order-select').change(function()
    {

        var items = $('.media-items').children();
        var itemsArr = [];
        items.each(function(i){ 
            $(items[i]).detach();
            itemsArr.push(items[i])
        });
        
        function comp(key)
        {
            return function(a, b) 
            {
                return $(a).attr(key).toLowerCase() > $(b).attr(key).toLowerCase() ? 1 : -1;
            }
        }
        
        itemsArr.sort(comp('data-media-'+$(this).val()));
          
        itemsArr.forEach(function(item) {
            $('.media-items').append($(item));
        });
    });
      
      $('.media-items').on('click', '.media-item', function(event)
      {
            event.stopPropagation();
            var wasSelected = $(this).hasClass('selected');
            $('.media-item.selected').removeClass('selected');
            if(!wasSelected)
            {
                $(this).addClass('selected');
            }
            $('.media-file-info').html('');
            if($(this).hasClass('selected'))
            {
                $('.media-file-info').append('<div class="media-file-info-item media-file-info-name"><span>Nom:</span><span>'+$(this).attr('data-media-name')+'</span></div>');
                if($(this).attr('data-media-dimensions'))
                {
                    $('.media-file-info').append('<div class="media-file-info-item media-file-info-dimensions"><span>Dimension de l\'image:</span><span>'+$(this).attr('data-media-dimensions')+'</span></div>');
                }
                if($(this).attr('data-media-size'))
                {
                    $('.media-file-info').append('<div class="media-file-info-item media-file-info-size"><span>Taille du fichier:</span><span>'+bytesToSize($(this).attr('data-media-size'))+'</span></div>');
                }     
                $('.media-file-info').append('<a href="'+BaseUrl+$(this).attr('data-media-url')+'">Télécharger</a> - ');
                 $('.media-file-info').append($(this).find('.media-delete').clone());
            }

      });

      $('.media-items, .media-file-info').on('click', '.media-delete', function()
      {
          if(!confirm('Êtes-vous sûr de vouloir supprimer ce fichier?')){
               return false;
          }
          var item = $('.media-items .media-item-'+$(this).find('.media-item-input-id').val());
          item.addClass('loading');
          var postData = $(this).find('form').serializeArray();
          $.ajax({
            url:BaseUrl+'/media/delete/',
            data:postData,
            context:{
              item:item
            },
            type: "POST",
            dataType:'json',
            success:function(data){
              this.item.fadeOut('fast');
              $('.media-file-info').html('');
            },
            error:function(data){
              alert('Erreur pendant la suppression');
            }
          });
      });
      
      
      $('.media-display-preferences').on('click', '.media-display-preferences-item', function(event)
      {
          $('.media-display-preferences-item.selected').removeClass('selected');
          $(this).addClass('selected');
          if($(this).attr('data-media-preference-type') == 'show-list')
          {
              $('.media-items').removeClass('media-display-grid');
              $('.media-items').addClass('media-display-list');
          }
          if($(this).attr('data-media-preference-type') == 'show-grid')
          {
              $('.media-items').removeClass('media-display-list');
              $('.media-items').addClass('media-display-grid');
          }
      });
      

      $('.modal-footer .btn-primary').on('click', function(){
        <?php 
        if($domId == 'tinymce')
        {
          ?>

            if(top.current_tinymce_callback)
            {
              var m = $('.media-item.selected').first()
              console.log('baseurl:'+BaseUrl)
              console.log('url:'+m.attr('data-media-url'))
              top.current_tinymce_callback(m.attr('data-media-url')+'_1024x0', {});
            }
            top.current_tinymce_callback = false;
            top.tinymce.activeEditor.windowManager.close();
<?php
        }else{
        ?>

        $('.media-item.selected').each(function(){
          $('#<?php echo $domId; ?>').val($(this).attr('data-media-url'));
          $('#media-<?php echo $domId; ?> .media-placeholder').html('<img src="'+BaseUrl+$(this).attr('data-media-url')+'" height="50" />');
        });
        $('#<?php echo $domId; ?>-finder  .media-modal-finder').modal('hide');

        <?php
        } ?>
      });
  });
</script> 
<?php 
echo $this->Html->css('Media.style.css'); ?>