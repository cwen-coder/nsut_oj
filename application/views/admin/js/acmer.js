$(document).ready(function(){
	$("#user_search_but").click(function() {
		/* Act on the event */
		var username = $("#user_search").val();
		//console.log(username);
		var url = $("#hid_site").val() + '/admin/acmer/user_search';
		$.post(url, {
				username: username
			}, function() {
			
		});
	});
});