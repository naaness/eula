$(document).ready(function(){
	$("#go-to-login").click(function(){
		server = "http://"+window.location.hostname;
		window.location.href = server +"/login";
	});
});