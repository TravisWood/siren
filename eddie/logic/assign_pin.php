<? include('../includes/config.php');

$user = R::load('users', $_POST['user_id']);
$user->pin = md5($_POST['create_pin']);
R::store($user);

echo json_encode(array('status' => 'success', 'message' => 'You pin has been set. Please write this down for later use.'));