$(document).ready(function() {
	$("a.imformation").click(function(event) {
		/* Act on the event */
		event.preventDefault();
		var solution_id = $(this).parent("td").parent("tr").find("td").eq(0).text();
		var result = $(this).parent("td").attr('class');
		//console.log(result);
		var url = $("#hid_site").val() + '/contest/home/false_imformation';
		$.post(url,{
			solution_id : solution_id,
			result : result
		},function(data) {
			if(data == false) {
				alert("对不起请求失败！");
			} else {
				//var info = eval("("+data+")");
				//console.log(info);
				$("#compile_info").text(data);
				$("#compile_info_but").click();
			}
		});
	});


	$("a.source_code").click(function(event) {
		/* Act on the event */
		event.preventDefault();
		var solution_id = $(this).parent("td").parent("tr").find("td").eq(0).text();
		var username = $(this).parent("td").parent("tr").find("td").eq(2).text();
		//var result = $(this).parent("td").attr('class');
		//console.log(result);
		var url = $("#hid_site").val() + '/contest/home/get_source_code';
		$.post(url,{
			solution_id : solution_id,
			username : username
		},function(data) {
			if(data == false) {
				alert("对不起请求失败！");
			} else {
				//var info = eval("("+data+")");
				//console.log(data);
				$("#source_code").text(data);
				$("#source_code_but").click();
			}
		});
	});
});