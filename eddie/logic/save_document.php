<? include('../includes/config.php');
include('../includes/functions.php');

$client = $_POST['client'];
$template = $_POST['template'];
$file = $_POST['file'];
$user_id = $_POST['user_id'];
$requested = $_SESSION['user_id'];

if (empty($client) || empty($user_id)):

	$result = array('status' => 'error', 'message' => 'You are missing some information. Please correct.');

else:

if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/signature/uploads/documents/'.$client)):
	mkdir($_SERVER['DOCUMENT_ROOT'].'/signature/uploads/documents/'.$client);
endif;

rename($_SERVER['DOCUMENT_ROOT'].'/signature/uploads/tmp/'.$file, $_SERVER['DOCUMENT_ROOT'].'/signature/uploads/documents/'.$client.'/'.$file);

$key = randKey(250, 4);


$doc = R::dispense('documents');
$doc->user_requested = $requested;
$doc->client_id = $client;
$doc->user_id = $user_id;

if (!empty($template)):
	$templates = R::load('templates', $template);
	$doc->template_content = $templates->content;
	$doc->template_id = $template;
endif;
$doc->document = $file;
$doc->inserted = date('Y-m-d');
$doc->status = 'unsigned';
$doc->secret_key = $key;
$doc_id = R::store($doc);


// find the info out for who sent the doc
$user = R::load('users', $requested);

// find the info out for who is receiving the doc
$sentto = R::load('users', $user_id);

/* ================================================
   Mailer START
=================================================== */ 
$subject = 'Please sign this document: '.$file.'';
$to = $sentto->email;
$headers = "From: Arrowhead Advertising <noreply@arrowheadadv.com>\r\n";
$headers .= "Reply-To: noreply@arrowheadadv.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .= '<div style="font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
<p>Please review and sign your document</p>

<div style="clear:both; height:10px;"></div>

<span style="display:block; float:left; width:50px;">From:</span> 
<span style="display:block; float:left;"><img src="http://development.arrowheadadv.com/signature/uploads/avatar/avatar-default.png" width="50" /></span>
<span style="display:block; float:left; margin:10px 0 0 10px;">'.$user->first_name.' '.$user->last_name.' (<a href="mailto:'.$user->email.'">'.$user->email.')</a><br /> Arrowhead Advertising</span>

<div style="clear:both; height:10px;"></div>

<p>Dear '.$sentto->first_name.' '.$sentto->last_name.',</p>

<p>Please click <a href="http://development.arrowheadadv.com/signature/sign.php?key='.$key.'" style="font-weight:bold;">here</a> to view and sign your document.</p>';

if (!empty($template)):
	$message .= $templates->content;
endif;

$message .= '<p>Please contact <a href="mailto:helpdesk@arrowheadadv.com">helpdesk@arrowheadadv.com</a> for questions or if you are having trouble opening up this document.</p>
<p>This message was sent to you by '.$user->first_name.' '.$user->last_name.' who is using the Arrowhead Advertising Document Application. If you would rather not receive email from this sender you may contact the sender with your request.</p>
</div>';
$message .= "</body></html>";

mail($to, $subject, $message, $headers);
/* ================================================
   Mailer END
=================================================== */

	$result = array('status' => 'success');

endif;

echo json_encode($result);

?>