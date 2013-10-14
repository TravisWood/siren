<? include('../includes/config.php');
include('../includes/functions.php');

$randkey = randKey(20, 4);

$output = array();
foreach($_POST['name'] as $key => $name):
    
	$output[$key]['name'] = $name;
    $output[$key]['price'] = $_POST['price'][$key];
    $output[$key]['type'] = $_POST['type'];

endforeach;

foreach ($output as $key => $value):

	$tmp = R::dispense('tmp');
	$tmp->name = $value['name'];
	$tmp->price = $value['price'];
	$tmp->category = $value['type'];
	$tmp->keycode = $randkey;
	$tmp_id = R::store($tmp);

endforeach;

echo json_encode(array('status' => 'success', 'key' => $randkey));

?>