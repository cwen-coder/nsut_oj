$(document).ready(function() {
	$("a[href='#myModal']").click(function() {
		var num_M = $(this).parent("td").parent("tr").find("td").eq(0).text();
		var num = $(this).parent("td").parent("tr").find("td").eq(0).attr('id');
		$("#problem_span").text(num_M);
		$("#problem_but_del").click(function() {
			/* Act on the event */
		});
	});
});