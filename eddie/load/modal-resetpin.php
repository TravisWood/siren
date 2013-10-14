<form id="resetPin" class="no-bottom-margin">
<input type="hidden" name="insert" id="insert" value="0" />
<div class="modal-header">
	<button type="button" class="close close-event" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Reset Your Security Pin</h3>
</div> <!-- end modal header -->

<div class="modal-body">
	<label>Please enter the keycode that was emailed to you. If you haven't received the email within 5 minutes, please check your spam folder or contact technical support<br /><br /><input type="text" id="reset_code" name="reset_code" class="required default" /></label>
    <div id="response"></div> <!-- end response -->
</div> <!-- end modal body -->

<div class="modal-footer">
    <a class="btn close-event" data-dismiss="modal">Close</a>
    <a href="#" class="btn btn-primary save-reset">Save changes</a>
    <img src="images/loading.gif" class="loading none" />
</div> <!-- end modal footer -->
</form>