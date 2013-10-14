<? include('includes/config.php');
header('X-Frame-Options: SAMEORIGIN'); 
include('includes/functions.php');

$browser = $_SERVER['HTTP_USER_AGENT'];

$key = $_GET['key'];

$doc = R::findOne('documents', 'secret_key =:secret_key', array('secret_key' => $key));
$template = R::load('templates', $doc->template_id);
$user = R::load('users', $doc->user_id);
$url = urlencode('http://development.arrowheadadv.com/signature/uploads/documents/'.$doc->client_id.'/'.$doc->document);
$type = pathinfo($url, PATHINFO_EXTENSION);
?>
<!DOCTYPE html>
<!--[if IE 7]><html class="ie7" lang="en"><![endif]-->
<!--[if lte IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="not-ie" lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Sign Docs</title>
<link rel="stylesheet" href="css/style.css" type="text/css"/>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="js/libs/flashcanvas.js"></script>
<![endif]-->
</head>

<body>

<? if (empty($user->pin)): ?>
<div class="modal-backdrop fade in" id="modal-bg"></div>
<div id="addPin" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:block;">
	<div class="modal-header">
	<button type="button" class="close closed" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">Security Pin</h3>
    </div> <!-- end modal header -->
    <form id="pinNum" class="no-bottom-margin">
    <input type="hidden" name="type" id="type" value="client"/>
    <div class="modal-body">

    	<div id="response"></div> <!-- end message -->
    	 <input type="hidden" name="user_id" value="<?= $doc->user_id; ?>" />
         <p><label>Create a Security Pin</label><input type="text" name="create_pin" id="create_pin" class="required default" /></p>

    </div> <!-- end modal body -->
    
    <div class="modal-footer">
    	<button class="btn dead closed" data-dismiss="modal" aria-hidden="true">Close</button>
    	<input type="submit" class="btn btn-primary pin-submit" value="Submit">
    </div> <!-- end modal-footer -->
	</form>
</div> <!-- end add user -->
<? endif; ?>

<div style="padding:0 2%;" class="clearfix">

<section id="iframe" class="clearfix">

<? if ($type == 'xls' || $type == 'xlsx'):

if ($browser != 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0'): ?>
<h2>View the file</h2>

<iframe src="https://docs.google.com/viewer?url=<?= $url; ?>&embedded=true" width="100%" height="500" style="border: none;"></iframe>

<? else:
echo '<h2>Download the File</h2>
<p class="clearfix">
<span class="block left right-1"><img src="img/icon-'.$type.'.png" class="top10" /></span> <span class="left block capitalize">'.$doc->document.'<br> <a href="http://development.arrowheadadv.com/signature/uploads/documents/'.$doc->client_id.'/'.$doc->document.'" style="font-size:12px;">Download</a></span>
</p>';
endif; 

else: ?>

<h2 class="left">View the file</h2>
<p class="right" style="margin-top:20px;"><img src="img/icon-<?= $type; ?>.png" /> <a href="uploads/documents/<?= $doc->client_id; ?>/<?= $doc->document; ?>" class="normal font-14">Download File</a></p>
<div class="clearfix"></div><!-- Clear -->


<iframe src="https://docs.google.com/viewer?url=<?= $url; ?>&embedded=true" width="100%" height="500" style="border: none;"></iframe>
	

<? endif; ?>

	<?= $template->content; ?>

	<img src="<?= $doc->signature; ?>" />


</section> <!-- end iframe -->

<div id="results"></div> <!-- end results -->

</div> <!-- end padding -->
  
<!-- include all the javascript -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/serializeObject.min.js"></script>
<script src="js/bootstrap-wysihtml5.js"></script>
<script src="js/jSignature.js"></script>
<script src="http://canvg.googlecode.com/svn/trunk/canvg.js"></script> 
<script src="js/scripts.js"></script>

<script type="text/javascript">
$(document).ready(function() {

getHeight();

var $sigdiv = $("#signature");
var sig = $('#signature');
$sigdiv.jSignature() // inits the jSignature widget.
$sigdiv.jSignature("reset") // clears the canvas and rerenders the decor on it.
	
//importImg(sig);

$('#save').on('click', function(event) {
	event.preventDefault();
	
	$(this).addClass('hide');
	$('#sign').removeClass('hide');
});

$('.pin-submit').on('click', function(event) {
	
	var i = $('#create_pin').val();
		
	$("#pinNum").validate({
	
	submitHandler: function(form) {
		
		var formData = $('form#pinNum').serializeObject();
				
			$.ajax({
				url:'logic/assign_pin.php',
				type: 'POST', 
				dataType: 'json',
				data: formData,
				success: function(data) {
					if (data.status == 'error') { 	
						$('#response').attr('class', '');
						$('#response').addClass('error').html(data.message).show();
					} else { 
						$('#response').attr('class', '');
						$('#response').addClass('success').html(data.message).show();
						$('#pin').val(i);
					} // end else		 
				},
				dataType: 'json'
			}); 	 			 
													
		} // end submit handler 
	}); // end validate	
		
});

$('.closed').on('click', function(event) {
	event.preventDefault();	
	
	$('#modal-bg').remove();
	$('#addPin').remove();
		
});


$('.submit').on('click', function(event) {
	event.preventDefault();
	
		$('img.loading').removeClass('none');
	
		var formData = $('form#sign').serializeObject();
				
		$.ajax({
			url:'logic/save_signature.php',
			type: 'POST', 
			dataType: 'json',
			data: formData,
			success: function(data) {
				if (data.status == 'error') { 	
					$('#message').attr('class', '');
					$('#message').addClass('error').html(data.message).show();
					$('img.loading').addClass('none');
				} else { 
					$('#message').attr('class', '');
					$('#message').addClass('success').html(data.message).show();
					$('form#sign').hide();
					$('img.loading').addClass('none');
					$('#iframe').html('');
					$('#results').html('<article><h3 class="normal">Thank You!</h3><p>We appreciate you signing/agreeing to this document.</p><p>If you have any questions, please feel free to call your account representative.</p><p><a href="#" class="close" style="float:left !important;">Click to close the window</a>.</p></article>');
					closeWindow();
				} // end else		 
			},
			dataType: 'json'
		}); 	 

});

$('.resetPin').on('click', function(event) {
	event.preventDefault();
			
	$.ajax({
		url:'logic/send_reset_pin.php',
		type: 'POST', 
		dataType: 'json',
		data: {'id':<?= $doc->user_id; ?>},
		success: function(data) {
			if (data.status == 'error') { 	
				console.log(data.status);	
			} // end if		
			else  { 
				
				var url = 'load/modal-resetpin.php';
	
				$.get(url, function(data) {
			
				$('<div class="modal hide fade" id="modalElement">' + data + '</div>').modal()
				.on('shown', function() {
	
					resetPin();
					
		
				}); // end callback
								
				}).success(function() { 	
				
					$('input:text:visible:first').focus(); 
			
				});	
				
			} // end else		 
		},
		dataType: 'json'
	}); 	 			
	
		
});

}); // end onload


function resetPin() {
	
	$('.save-reset').on('click', function(event) {
		event.preventDefault();
		
		var i = $('#insert').val();
		var formData = $('form#resetPin').serializeObject();
		
		if (i == 1) {
			
			var pinNumber = $('#pin_number').val();
			var user_id = <?= $doc->user_id; ?>;
			var uri = 'logic/reset_pin.php';
			var Data = {'pin_number':pinNumber, 'user_id':user_id, 'insert':i}
			
			console.log(pinNumber);
			
		} else {
			var Data = formData;
			var uri = 'logic/confirm_pin.php';
		} // end else
	
			$.ajax({
				url:uri,
				type: 'POST', 
				dataType: 'json',
				data: Data,
				success: function(data) {
					if (data.status == 'error') { 	
						$('#response').attr('class', '');
						$('#response').addClass('error').html(data.message).show();
					} else if (data.status == 'reset') { 
						$('#response').attr('class', '').hide();
						
						$('#resetPin .modal-body').html('<input type="hidden" name="user_id" value="<?= $doc->user_id; ?>" /><label>Enter a new Security Pin Number<br /><input type="text" name="pin_number" id="pin_number" class="required default" /></label><div id="response"></div>');
						$('#resetPin input#insert').val('1');
						$('#resetPin').attr('id', 'submitReset');					
					} else {
						$('#response').attr('class', '');
						$('#response').addClass('success').html(data.message).show();
						$('#pin').val(data.pin);
					} // end else
				},
				dataType: 'json'
			}); 	 			 
	});
	
} // end function

function closeWindow() {
	
	$('.close').on('click', function(event) {
		event.preventDefault();
		window.close();
	});
	
} // end function

function getHeight() {
	var height = $('iframe').contents().height()+'px';
	console.log(height);
	
} // end function
</script>
</body>
</html>