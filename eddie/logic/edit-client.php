<? include('../includes/config.php');

$client_id = $_POST['client_id'];
$name = $_POST['business_name'];

$clients = R::load('clients', $client_id);
$clients->business_name = $name;
R::store($clients);

echo json_encode(array('status' => 'success', 'message' => 'This client has been updated successfully. Please close the window.'));