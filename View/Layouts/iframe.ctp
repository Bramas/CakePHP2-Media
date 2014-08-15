<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $this->fetch('title'); ?></title>
    <?php

  echo $this->Html->script('//code.jquery.com/jquery-2.1.0.min.js');
  echo $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css');
  echo $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css');
  echo $this->Html->script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js');
  echo $this->Html->script('//tinymce.cachefly.net/4.1/tinymce.min.js');
  echo $this->Html->css('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
echo $this->Html->script('Admin.admin.js');
echo $this->Html->css('Admin.dashboard.css');
    ?>
<script type="text/javascript">
  var AdminBaseUrl = '<?php echo $this->Html->url('/admin/'); ?>';
  var BaseUrl = '<?php echo $this->Html->url('/'); ?>';
  if(BaseUrl == '/')
  {
    BaseUrl = '';
  }
  var AdminFirstUrl = '<?php echo $this->request->here; ?>';
</script>
  </head>
  <body style="padding: 15px;">
    <div class="container-fluid">
      <div class="row">
          <div id="layoutContent">
            <?php echo $this->fetch('content'); ?>
            <div class="modal-footer">
              <button onclick="javascript:top.tinymce.activeEditor.windowManager.close();" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <button type="button" class="btn btn-primary btn-disabled">Choisir</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>