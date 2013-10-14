<? include('../includes/config.php');
include('../includes/functions.php');

$key = randKey(8, 4);

$user = R::load('users', $_POST['id']);
$user->reset_pin = $key;
R::store($user);

if (!empty($user)):

$to = $user->email;
$subject = 'Reset Pin Number: Admiral (Arrowhead Advertising)';
		
$headers = "From: noreply@arrowheadadv.com\r\n";
$headers .= "Reply-To: noreply@arrowheadadv.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
$message = '<html><body>';
$message .= '<p>You are receiving this email to reset the pin number associated with your Admiral account.</p>';
$message .= '<p>Please use the following code to reset your security pin: <strong>'.$key.'</strong></p>';
$message .= '<p>If you did not choose to reset your pin, please disregard this email entirely</p>';
$message .= '<p>Sincerely, <br />The Arrowhead Advertising Technical Team</p>';
$message .= "</body></html>";
		
mail($to, $subject, $message, $headers);

	$response = array('status' => 'success');

else:
	$response = array('status' => 'error', 'message' => 'No account found. Please try again or contact technical support.');
endif;

echo json_encode($response);