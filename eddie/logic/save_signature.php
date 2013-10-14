<? include('../includes/config.php'); 

$pin = $_POST['pin'];
$user = R::findOne('users', 'pin =:pin', array('pin' => md5($pin)));

if (empty($_POST['full_name']) || empty($_POST['signature'])) {

	$result = array('status' => 'error', 'message' => 'You are missing some information.');
} // end if

elseif (empty($user)){
	$result = array('status' => 'error', 'message' => 'The Pin number you entered does not match. Please re-enter.');
} // end else if

else {

	$doc = R::load('documents', $_POST['document_id']);
	$requested = R::load('users', $doc->user_requested);
	
	$doc->status = 'signed';
	$doc->ip = $_SERVER["REMOTE_ADDR"];
	$doc->typed_name = $_POST['full_name'];
	$doc->date_signed = R::$f->now();
	$doc->signature = $_POST['signature'];
	
	$doc_id = R::store($doc);
	
	$client = R::load('clients', $doc->client_id);
	
	$to = $requested->email;
	$subject = 'Document ('.$doc->document.') has been signed by: '.$doc->typed_name.'';
			
	$headers = "From: Arrowhead Advertising <noreply@arrowheadadv.com>\r\n";
	$headers .= "Reply-To: noreply@arrowheadadv.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
	$message .= '<html><body>';
	$message .= '<p>'.$requested->first_name.',</p>';
	$message .= '<p>'.$doc->typed_name.' has successfully signed the document (<a href="http://development.arrowheadadv.com/signature/sign.php?key='.$doc->secret_key.'">'.$doc->document.'</a>) assigned to '.$client->business_name.'</p>';
	$message .= '<p>The document details are as followed:'."\n\n";
	$message .= '<p>Document Creation Date: '.date('m/d/Y',strtotime($doc->inserted)).'<br />';
	$message .= 'Assigned Client: '.$client->business_name.'<br />';
	$message .= 'Assigned to User '.$user->first_name.' '.$user->last_name.'<br />';
	$message .= 'Date Signed: '.date('m/d/Y',strtotime($doc->date_signed)).'<br />';
	$message .= 'IP Associated with Signature: '.$doc->ip.'<br />';
	$message .= 'Name Typed with Signature: '.$doc->typed_name.'</p>';
	$message .= '<p>To email the contents of the document & the signature, please login to the Signature App and click on the "Reports" tab.</p>';
	$message .= "</body></html>";
			
	mail($to, $subject, $message, $headers);
	
	$result = array('status' => 'success', 'message' => 'Thank you for your signature. The document has been updated.');
} // end else

echo json_encode($result);
?>