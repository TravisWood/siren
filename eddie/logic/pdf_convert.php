<?php include('../includes/config.php');

$id = $_POST['doc_id'];
$email = $_POST['email'];

$document = R::load('documents', $id);
$client = R::load('clients', $document->client_id);
$user = R::load('users', $document->user_id);
$requested = R::load('users', $document->user_requested);

$from = "Arrowhead Advertising <noreply@arrowheadadv.com>";
$to = $email;
$subject = 'Document(s) and Details Signed by '.$document->typed_name.' <'.$client->business_name.'>';
$message .= 'The document details are as followed:'."\n\n";
$message .= 'Document Creation Date: '.date('m/d/Y',strtotime($document->inserted))."\n";
$message .= 'Assigned Client: '.$client->business_name."\n";
$message .= 'Assigned to User '.$user->first_name.' '.$user->last_name."\n";
$message .= 'Date Signed: '.date('m/d/Y',strtotime($document->date_signed))."\n";
$message .= 'IP Associated with Signature: '.$document->ip."\n";
$message .= 'Name Typed with Signature: '.$document->typed_name."\n";

// convert the signature to an actual file
$image = $_SERVER['DOCUMENT_ROOT'].'/signature/uploads/documents/'.$document->client_id.'/signature.png';
$data = $document->signature;
list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);
$data = base64_decode($data);
file_put_contents($image, $data);

$file1 = $_SERVER['DOCUMENT_ROOT'].'/signature/uploads/documents/'.$document->client_id.'/'.$document->document;
$file2 = $image;

// File names of selected files
$filename1 = $document->document;
$filename2 = 'signature.png';

// array of filenames to be as attachments
$files = array($file1, $file2);
$filenames = array($filename1, $filename2);

// include the from email in the headers
$headers = "From: $from";

// boundary
$time = md5(time());
$boundary = "==Multipart_Boundary_x{$time}x";

// headers used for send attachment with email
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$boundary}\"";

// multipart boundary
$message = "--{$boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
$message .= "--{$boundary}\n";

// attach the attachments to the message
for($x = 0; $x < count($files); $x++){
	$file = fopen($files[$x],"r");
	$content = fread($file,filesize($files[$x]));
	fclose($file);
	$content = chunk_split(base64_encode($content));
	$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" . "Content-Disposition: attachment;\n" . " filename=\"$filenames[$x]\"\n" . "Content-Transfer-Encoding: base64\n\n" . $content . "\n\n";
	$message .= "--{$boundary}\n";
}

// sending mail
$sendmail = mail($to, $subject, $message, $headers);

// verify if mail is sent or not
if ($sendmail):
   $result = array('status' => 'success', 'message' => 'Your documents have been sent. Please close the window.');
else:
    $result = array('status' => 'error', 'message' => 'There was an error. Please try again.');
endif;

echo json_encode($result);
?>