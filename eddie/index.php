<? include('includes/config.php');
include('includes/functions.php');

// find out how many documents have been created
$docs = R::findAll('documents');
$sentout = count($docs);

// find out how many have been signed
$docs2 = R::find('documents', 'status =:status', array('status' => 'signed'));
$signed = count($docs2);
?>
<!DOCTYPE html>
<!--[if IE 7]><html class="ie7" lang="en"><![endif]-->
<!--[if lte IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="not-ie" lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Sign Docs</title>
<link rel="stylesheet" href="css/style.css" type="text/css"/>
<link rel='stylesheet' href='css/cupertino/theme.css' />
<link rel="stylesheet" type="text/css" href="css/bootstrap-wysihtml5.css"></link>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>

<? if (!$_SESSION): ?>
<div id="login-bg"></div> <!-- end login bg -->
<div class="modal hide fade in" style="display:block;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>You Must Login</h3>
  </div>
  <form id="login">
  <div class="modal-body">
    <div class="message"></div> <!-- end message -->
    <p><label>Email Address</label><input type="text" name="email" id="email" class="required default" /></p>
    <p><label>Password</label><input type="password" name="password" id="password" placeholder="********" class="required default" /></p>
    <p><input type="submit" class="btn-primarty btn login" value="Login" /></p>
   
  </div> <!-- end modal body -->
  </form>
</div> <!-- end modal -->
<? endif; ?>

<? include('includes/sidebar.php'); ?>

<section id="main" class="clearfix">
	
<? include('includes/header.php'); ?>


<div class="right eighty5 allstuff">

	<article>
    	<h3 class="normal">Request Signatures</h3>
        <button class="btn btn-large btn-primary create" data-type="document">Create a Document</button> <img src="img/ajax-loader.gif" class="load none" />
    </article>
    
    <div id="content"></div> <!-- end content -->

</div> <!-- end left -->

</section> <!-- end main -->



<!-- include all the javascript -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>
<script src="js/serializeObject.min.js"></script>
<script src="js/wysihtml5-0.3.0.js"></script>
<script src="js/bootstrap-wysihtml5.js"></script>
<script src="js/scripts.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$('.login').on('click', function(event) {
		
		$("#login").validate({
			submitHandler: function(form) {
			
				var email = $('form#login #email').val();
				var password = $('form#login #password').val();
				
				login(email, password);
						
			} // end submit handler 
		}); // end validate
		
	});
	
}); // end onload
</script>

</body>
</html>