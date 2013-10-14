<? include('../includes/config.php');
 
if ($_GET['type'] == 'add'):
	$button = 'submit';
else:
	$button = 'update';
endif;
?>
<form id="template" class="no-bottom-margin">

<div class="modal-header">
	<button type="button" class="close close-event" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Add New Template</h3>
</div> <!-- end modal header -->

<div class="modal-body">

	<div class="message"></div> <!-- end message -->

	<? if (!empty($_GET['id'])): 
	   $templates = R::load('templates', $_GET['id']); ?>
    <input type="hidden" name="template_id" value="<?= $templates->id; ?>" />   
       
	<label>Template Name <input type="text" name="template_name" value="<?= $templates->name; ?>" class="required block default" /></label>

	<label>Template Content
	<textarea class="textarea required" name="template_content" placeholder="Enter content..." style="width:100%; height:200px"><?= $templates->content; ?></textarea></label>
    <? else: ?>
    <label>Template Name <input type="text" name="template_name" class="required block default" /></label>

	<label>Template Content
	<textarea class="textarea required" name="template_content" placeholder="Enter content..." style="width:100%; height:200px"></textarea></label>
	<? endif; ?>

</div> <!-- end modal body -->

<div class="modal-footer">
    <a class="btn close-event close-template" data-dismiss="modal">Close</a>
    <a href="#" class="btn btn-primary <?= $button; ?>">Save changes</a>
    <img src="images/loading.gif" class="loading none" />
</div> <!-- end modal footer -->
</form>