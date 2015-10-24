$(document).ready(function() {
	$("a.imformation").click(function(event) {
		/* Act on the event */
		event.preventDefault();
		var solution_id = $(this).parent("td").parent("tr").find("td").eq(0).text();
		var username = $(this).parent("td").parent("tr").find("td").eq(2).text();;
		console.log(username);
		var url = $("#hid_site").val() + '/contest/home/false_imformation/'+solution_id+'/'+username;
		window.open(url, "_blank");
	});
});