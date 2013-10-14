<? include('../includes/config.php');
include('../includes/functions.php');

if ($_GET['type'] == 'template'):

	$name = $_POST['template_name'];
	$content = $_POST['template_content'];
	
	if (empty($name) || empty($content)):
	
		$result = array('status' => 'error', 'message' => 'You are missing some information.');
		
	else:

	$exists = exist('templates', 'name', $name);
	
		if ($exists == false):
		
			$template = R::dispense('templates');
			$template->name = $name;
			$template->content = $content;
			$template_id = R::store($template);
			
			$result = array('status' => 'success', 'message' => 'The template has been created. Please close the window.');
		
		else:
			$result = array('status' => 'error', 'message' => 'There is already a template with this name.');
		endif;
	
	endif;
	
endif;

if ($_GET['type'] == 'user'):

	if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['permission'])):
	
		$result = array('status' => 'error', 'message' => 'You are missing some information.');
		
	else:
	
		$exists = exist('templates', 'email', $_POST['email']);
	
		if ($exists == false):
		
			$user = R::dispense('users');
			$user->first_name = $_POST['fname'];
			$user->last_name = $_POST['lname'];
			$user->email = $_POST['email'];
			$user->password = md5($_POST['password']);
			$user->permission = $_POST['permission'];
			
				if (!empty($_POST['client_id'])):
					$user->client_id = $_POST['client_id'];
					$user->company = NULL;
				else:
					$user->client_id = NULL;
					$user->company = 'Arrowhead Advertising';
				endif;
			$user_id = R::store($user);	
			
			$result = array('status' => 'success', 'message' => 'The user account has been created. Please close the window.', 'user_id' => $user_id);
			
			
				$to = $_POST['email'];
				$subject = 'Signature Account Creation';
				
				$headers = "From: noreply@arrowheadadv.com\r\n";
				$headers .= "Reply-To: noreply@arrowheadadv.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
				$message = '<html><body>';
				$message .= '<p>'.$_POST['fname'].',</p>';
				$message .= '<p>Your account has been created for the Arrowhead Advertising Document Signature application.</p>';
				$message .= '<p>Your Login Credentials are:</p>';
				$message .= '<p>Username: '.$_POST['email'].'<br />Password: '.$_POST['password'].'</p>';
				$message .= '<p>To login, click on this link: <a href="http://development.arrowheadadv.com/signature">Login Here</a></p>';
				$message .= "</body></html>";
				
				mail($to, $subject, $message, $headers);
			
					
		else:
			$result = array('status' => 'error', 'message' => 'There is already an account with that email address.');
		endif;
	
	endif;

endif;

if ($_GET['type'] == 'client'):

	if (empty($_POST['business_name'])):
		$result = array('status' => 'error', 'message' => 'You are missing some information.');
	else:
		
		$exists = exist('clients', 'business_name', $_POST['business_name']);
	
		if ($exists == false):
			
			$client = R::dispense('clients');
			$client->business_name = $_POST['business_name'];
			$client_id = R::store($client);
			
			$result = array('status' => 'success', 'message' => 'The Client has been created. Please close the window.', 'client_id' => $client_id);
			
		else:
			$result = array('status' => 'error', 'message' => 'There is already an client with that name.');
		endif;
		
	endif;

endif;

echo json_encode($result);

?>