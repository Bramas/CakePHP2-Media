<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">
    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
  </button>
  <h4 class="modal-title" id="myModalLabel"><?php echo $this->fetch('title'); ?></h4>
</div>
<div class="modal-body">
<?php echo $this->fetch('content'); ?>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
  <button type="button" class="btn btn-primary btn-disabled">Choisir</button>
</div>