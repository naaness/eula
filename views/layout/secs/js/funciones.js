$(document).ready(function(){
	$("#barrita").animate({'width':20+'%'},500,function(){
		$("#barrita").animate({'width':40+'%'},50,function(){
			//$("#barrita").hide();
		});
	});

});

$(window).load(function(){
	$("#barrita").animate({'width':100+'%'},function(){
		$("#barrita").hide();
	});
});
