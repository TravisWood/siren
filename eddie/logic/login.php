<? session_start();
include('../includes/config.php');

$email = $_POST['email'];
$password = md5($_POST['password']);

$user = R::findOne('users', 'email =:email AND password =:password', array('email' => $email, 'password' => $password));

if (!empty($user) && $user->permission != 'user'){

	$_SESSION['user_id'] = $user->id;
	$_SESSION['name'] = $user->first_name.' '.$user->last_name;
	$_SESSION['type'] = $user->permission;
	
	$result = array('status' => 'success', 'user_id' => $_SESSION['user_id'], 'type' => $_SESSION['type']);
	
} // end if

else if ($user->permission == 'user'){
	$result = array('status' => 'error', 'message' => 'You do not have permission to access this page.');
} // end if

else {
	$result = array('status' => 'error', 'message' => 'The username/password does not match. Please try again.');
} // end else

echo json_encode($result);

?>