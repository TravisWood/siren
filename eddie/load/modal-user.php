<? include('../includes/config.php');
include('../includes/functions.php');

if ($_GET['user_id']):	
	$user = R::load('users', $_GET['user_id']);
	$fname = $user->first_name;
	$lname = $user->last_name;
	$email = $user->email;
	$permission = $user->permission;
	$client_id = $user->client_id;
	$button = 'edit-user';
	
	$hidden = '<input type="hidden" name="user_id" id="user_id" value="'.$_GET['user_id'].'" />';
	$close = 'close-manage';
	
else:
	$button = 'submit';
	$close = '';
endif; ?>

<form id="user" class="no-bottom-margin">
<?= $hidden; ?>
<div class="modal-header">
	<button type="button" class="close close-event <?= $close; ?>" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Add New User</h3>
</div> <!-- end modal header -->

<div class="modal-body">
	<div class="message"></div> <!-- end message -->

	<label>First Name <input type="text" name="fname" class="required block default" value="<?= $fname; ?>" /></label>
    <label>Last Name <input type="text" name="lname" class="required block default" value="<?= $lname; ?>" /></label>
    <label>Email Address <input type="email" name="email" class="required email block default" value="<?= $email; ?>" /></label>
    <label>Password <input type="password" name="password" class="required block default" /></label>
    <label>Account Permissions
    <select name="permission" id="permissions" class="default block">
    	<option value="" selected>Select</option>
        <option value="user" <?= account_type($permission, 'user'); ?>>User</option>
        <option value="arrowhead" <?= account_type($permission, 'arrowhead'); ?>>Arrowhead Employee</option>
        <option value="admin" <?= account_type($permission, 'admin'); ?>>Admin</option>
    </select></label>
    
    <? $clients = R::findAll('clients'); 
	?>
	
	<label>Associated Client
	<select name="client_id" class="default block">
	<option value="" selected>Select</option>
	<? foreach ($clients as $key => $client): 
	
		if ($client->id == $client_id):
			$selected = 'selected="selected"';
		else:
			$selected = '';
		endif;
	
	?>
		<option value="<?= $client->id; ?>" <?= $selected; ?>><?= $client->business_name; ?></option>
	<? endforeach; ?>
	</select>
    
    <div id="add_fields"></div> <!-- end add fields --> 
</div> <!-- end modal body -->

<div class="modal-footer">
    <a class="btn close-event <?= $close; ?>" data-dismiss="modal">Close</a>
    <a href="#" class="btn btn-primary <?= $button; ?>">Save changes</a>
    <img src="images/loading.gif" class="loading none" />
</div> <!-- end modal footer -->
</form>