$(document).ready(function() {
	$('[id^="edit_"]').click(function(){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		$.post(server+'/cursos/get_audios/'+purldf, , function(data){
	});
});