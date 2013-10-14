
$(document).ready(function(){	
	$('.tools ul').hide();
	$('.tools').click(function() {
		$('.tools ul').slideToggle(1000);
		return false;
	});
});
