<? include('../includes/config.php');
include('../includes/functions.php');

if ($_GET['type'] == 'template'):

	$name = $_POST['template_name'];
	$content = $_POST['template_content'];
	
	if (empty($name) || empty($content)):
		$result = array('status' => 'error', 'message' => 'You are missing some information.');
	else:

	$template = R::load('templates', $_POST['template_id']);
	$template->name = $name;
	$template->content = $content;
	R::store($template);
	
	$result = array('status' => 'success', 'message' => 'The template has been created. Please close the window.');
	
	endif;

endif;

echo json_encode($result);

?>