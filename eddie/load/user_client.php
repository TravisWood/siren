<? include('../includes/config.php'); ?>
<p><label>Contact Name</label>
<select name="user_id">
	<option value="" selected>Select</option>
	<? $users = R::find('users', 'client_id =:client_id', array('client_id' => $_GET['id'])); 
	foreach ($users as $key => $user): ?>
    <option value="<?= $user->id; ?>"><?= $user->first_name.' '.$user->last_name; ?></option>
    <? endforeach; ?>
</select>
</p>
<div class="clearfix"></div><!-- Clear -->