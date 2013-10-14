<? include('../includes/config.php');

$user = R::findOne('users', 'reset_pin =:reset_pin', array('reset_pin' => $_POST['reset_code']));

if (!empty($user)):
	$result = array('status' => 'reset');
else:
	$result = array('status' => 'error');
endif;

echo json_encode($result);
?>