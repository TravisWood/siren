<? include('../includes/config.php');

$user_id = $_POST['user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$permissions = $_POST['permission'];
$client_id = $_POST['client_id'];

$user = R::load('users', $user_id);
$user->first_name = $fname;
$user->last_name = $lname;
$user->email = $email;
$user->permission = $permissions;

if (!empty($password)):
	$user->password = md5($password);
endif;

$user->client_id = $client_id;
R::store($user);

echo json_encode(array('status' => 'success', 'message' => 'This account has been updated successfully. Please close the window.'));