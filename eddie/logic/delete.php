<? include('../includes/config.php'); 

$id = $_POST['id'];
$type = $_POST['type'];

$account = R::load($type, $id);
R::trash($account);

echo json_encode(array('status' => 'success'));
?>