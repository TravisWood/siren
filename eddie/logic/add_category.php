<? ini_set('display_errors',1);
error_reporting(E_ALL);
include('../includes/config.php'); include('../includes/functions.php');

$exists = exist('categories', 'name', $_POST['cat_name']);

if ($exists == false):

	$cat = R::dispense('categories');
	$cat->name = $_POST['cat_name'];
	$cat_id = R::store($cat);
	
	$result = array('status' => 'success', 'cat_id' => $cat_id);

else:
	$result = array('status' => 'error', 'message' => 'Category Already Exists');
endif;

echo json_encode($result);

?>