
$(document).ready(function() {
	 //Activate tooltips
	$('.btn-default').click( function(){
		$('.btn-default').removeClass('active');
		$(this).addClass('active');
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		$("#tipo").val(id);
	});
});