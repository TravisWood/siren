<? include('../includes/config.php');
 
$id = $_GET['id'];
?>
<form id="email_documents" class="no-bottom-margin">

<div class="modal-header">
	<button type="button" class="close close-event" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Email Document Details + Files</h3>
</div> <!-- end modal header -->

<div class="modal-body">

	<p>Please enter the email you wish the information to go:</p>

	<div class="message"></div> <!-- end message -->

    <input type="hidden" name="doc_id" id="doc_id" value="<?= $id; ?>" /> 
    
    <label>Email Address <input type="text" name="email" id="email" class="default required email" /></label>       

</div> <!-- end modal body -->

<div class="modal-footer">
    <a class="btn close-event close-template" data-dismiss="modal">Close</a>
    <a href="#" class="btn btn-primary sendEmail">Send Email</a>
    <img src="images/loading.gif" class="loading none" />
</div> <!-- end modal footer -->
</form>