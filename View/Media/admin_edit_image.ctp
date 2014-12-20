<div class="media-edit-wrapper"><div class="media-edit-image-wrapper"><?php

$image = $image['Media'];

echo $this->Html->image($image['url'], array('id'=>'mediaImageEdit'));
/*
$this->Html->css('Media.jquery.Jcrop.min.css',  array('inline' => false));
$this->Html->script('Media.jquery.Jcrop.min.js',  array('inline' => false));
$this->Html->script('Media.jquery.color.js',  array('inline' => false));*/

$this->Html->css('Media.cropper.min.css',  array('inline' => false));
$this->Html->script('Media.cropper.min.js',  array('inline' => false));

?>
</div>
<div class="media-edit-desc-wrapper">
    <div class="media-edit-desc-group media-edit-desc-group-crop">
        <a data-media-image-edit-action-type="crop" href="#" class="media-edit-desc-group-label btn btn-default">Recadrer</a>
        <div class="media-edit-desc-group-content">
            <div class="media-edit-desc-preview"></div>
            <a href="#" class="media-crop-cancel btn btn-default">Annuler</a>
            <a href="#" class="media-crop-apply btn btn-default">Appliquer</a>
        </div> 
    </div>
<div class="media-edit-desc-actions">
    <div class="media-edit-desc-action media-edit-desc-action-rotate-left">left</div>
    <div class="media-edit-desc-action media-edit-desc-action-rotate-left">right</div>
    </div>
</div>
<script type="text/javascript">
   
var $image = $("#mediaImageEdit");
    
function startCropper()
{
    var $dataX = $("#dataX"),
    $dataY = $("#dataY"),
    $dataHeight = $("#dataHeight"),
    $dataWidth = $("#dataWidth");

    function onDragMove(e) { 
        var d = $("#mediaImageEdit").cropper("getData");
        var ratio = d.width / d.height;
        var prev = $('.media-edit-desc-preview');
        if(ratio > 1)
        {
            prev.css('width', 'auto');
            prev.css('height', prev.width() / ratio);
        }
        else
        {
            prev.css('width', 'auto');
            prev.css('height', prev.width());
            prev.css('width', ratio * prev.height());
        }

    }
    
    $image.cropper({
        data: {
            x: 480,
            y: 60,
            width: 640,
            height: 360
        },
        preview: ".media-edit-desc-preview",
        done: function(data) {
            $dataX.val(data.x);
            $dataY.val(data.y);
            $dataHeight.val(data.height);
            $dataWidth.val(data.width);
        },
        dragmove: onDragMove
    });
    onDragMove();
    console.log('?');
}
    
$('.media-edit-desc-group-content').hide();
$('.media-edit-desc-group-label').click(function(e){
    e.preventDefault();
    $(this).parent().find('.media-edit-desc-group-content').slideDown();
    if($(this).attr('data-media-image-edit-action-type') == 'crop')
    {
        startCropper();
    }
});
    
    $('.media-edit-desc-group-crop .media-crop-cancel').click(function(e){
        e.preventDefault();
        $image.cropper("destroy");
        $('.media-edit-desc-group-crop .media-edit-desc-group-content').slideUp();
    });
    
    $('.media-edit-desc-group-crop .media-crop-apply').click(function(e){
        e.preventDefault();
        if(!confirm("Êtes-vous sur de vouloir recadrer définitivement l'image?"))
        {
            return;
        }
        var d = $image.cropper("getData");
        $.ajax({
            url:BaseUrl+'/media/crop/<?php echo $image['id']; ?>/'+d.x+'/'+d.y+'/'+d.width+'/'+d.height,
            dataType: 'json',
            success:function(data)
            {
                if(!data.success)
                {
                    console.log(data.message);
                    return;
                }
                location.reload();
            }
        })
    });

</script>
</div>