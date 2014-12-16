$(document).ready(function() {
	var server = "http://"+window.location.hostname;
	$('[id^="edit_"]').click(function(){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		$.post( server+'/cursos/texto_respuesta','id='+id+'&texto='+$('#txt_'+id).val(), function() {
		  document.location.reload();
		})
	});
});