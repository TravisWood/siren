<? include('../includes/config.php');

$user = R::load('users', $_POST['user_id']);

if (!empty($user)):

	$user->pin = md5($_POST['pin_number']);
	$user->reset_pin = NULL;
	R::store($user);
	
	$result = array('status' => 'success', 'message' => 'You have successfully reset your security pin. Please close the window to continue.', 'pin' => $_POST['pin_number']);

else:

	$result = array('status' => 'error', 'message' => 'There was an error. please try again or contact technical support.');

endif;

echo json_encode($result);

?>