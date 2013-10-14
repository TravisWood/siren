<? include('../includes/config.php'); 
$template = R::load('templates', $_GET['id']);
?>


<div class="modal-header">
	<button type="button" class="close close-event" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3><?= $template->name; ?></h3>
</div> <!-- end modal header -->

<div class="modal-body">

	<?= $template->content; ?>

</div> <!-- end modal body -->

<div class="modal-footer">
    <a class="btn close-event" data-dismiss="modal">Close</a>
</div> <!-- end modal footer -->