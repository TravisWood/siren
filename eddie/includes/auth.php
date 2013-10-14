<? session_start();
if (empty($_SESSION['user_id'])) { 

	header('Location: /admiral/login.php'); 
} // end if 
?>