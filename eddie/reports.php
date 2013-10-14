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
<link rel="stylesheet" href="css/datepicker.css" type="text/css"/>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="js/libs/flashcanvas.js"></script>
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
<? include('includes/header.php'); ?>

<section id="main" class="clearfix padding1">



<div class="right eighty5 allstuff">

	<article class="filter">
    
    	<h3 class="normal">Filter Search Results</h3>
    
    	<form id="filter" class="clearfix no-bottom-margin">
        
        	<div class="input-append datepicker left thirty" data-date-format="yyyy-mm-dd">
            	<label>Date From:</label>
                <input size="16" type="text" name="from" id="from" value="" class="dates ninety">
                <span class="add-on" rel="tooltip" title="choose date" style="height:29px;"><i class="icon-calendar"></i></span>
            </div>
            <div class="input-append datepicker left thirty" data-date-format="yyyy-mm-dd">
            	<label>Date To:</label>
                <input size="16" type="text" name="to" id="to" value="" class="dates ninety">
                <span class="add-on" rel="tooltip" title="choose date" style="height:29px;"><i class="icon-calendar"></i></span>
            </div>
            <div class="clearfix"></div><!-- Clear -->
            <label class="left block thirty">Client<br />
            <select name="client_id" id="client_id" class="ninety">
            	<option value="" selected>Select</option>
                <? $clients = R::find('clients'); 
					foreach ($clients as $key => $client):
						echo '<option value="'.$client->id.'">'.$client->business_name.'</option>';
					endforeach;
				?>
            </select>
            </label>
            <label class="left block thirty">Status<br />
            <select name="status" id="status" class="ninety">
            	<option value="" selected>Select</option>
                <option value="signed">Signed</option>
                <option value="unsigned">Unsigned</option>
            </select>
            </label>
        
        </form>
    
    	<h3 class="normal">Documents Sent out (by client)</h3>
    	<p class="center top10 none loading"><img src="img/ajax-loader.gif" /></p>
    	<div id="content" class="clearfix"></div> <!-- end content -->
    
    </article>

</div> <!-- end left -->

</section> <!-- end main -->


<!-- include all the javascript -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/serializeObject.min.js"></script>
<script src="js/bootstrap-wysihtml5.js"></script>
<script src="js/jSignature.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="http://canvg.googlecode.com/svn/trunk/canvg.js"></script> 
<script src="js/jquery.fileupload.js"></script>
<script src="js/wysihtml5-0.3.0.js"></script>
<script src="js/scripts.js"></script>

<script>
$(document).ready(function() {
	
	filterSearch();
	
	$('.dates').datepicker();
	$('#from, #to').on('changeDate', function() {
		filterSearch();
	});
	$('#client_id, #status').on('change', function(event) {
		filterSearch();
	});
	
}); // end onload
</script>

</body>
</html>