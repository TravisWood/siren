<? include('../includes/config.php');
include('../includes/functions.php');

if ($_GET['client_id']):	
	$clients = R::load('clients', $_GET['client_id']);
	$name = $clients->business_name;
	$button = 'edit-user';
	
	$hidden = '<input type="hidden" name="client_id" id="client_id" value="'.$_GET['client_id'].'" />';
	$close = 'close-manage';
	
else:
	$button = 'submit';
	$close = '';
endif; ?>
<form id="client" class="no-bottom-margin">
<?= $hidden; ?>
<div class="modal-header">
	<button type="button" class="close close-event <?= $close; ?>" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Add New User</h3>
</div> <!-- end modal header -->

<div class="modal-body">
	<div class="message"></div> <!-- end message -->

	<label>Business Name <input type="text" name="business_name" value="<?= $name; ?>" class="required block default" /></label>
    
</div> <!-- end modal body -->

<div class="modal-footer">
    <a class="btn close-event <?= $close; ?>" data-dismiss="modal">Close</a>
    <a href="#" class="btn btn-primary <?= $button; ?>">Save changes</a>
    <img src="images/loading.gif" class="loading none" />
</div> <!-- end modal footer -->
</form>