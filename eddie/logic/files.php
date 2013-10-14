<? session_start();  
include('../includes/config.php'); 
include('../includes/functions.php');
	
$file = $_FILES['files'];

projectFiles($file);
 
?> 