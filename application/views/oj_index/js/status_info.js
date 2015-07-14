$(document).ready(function(){
	$("a.compileinfo").click(function(){
		var solution_id = $(this).parent().parent().find("#solution_id").text();
		var path = $("#hid_site").val();
		console.log(path);
		//alert("11111");
		var url = path+"/oj_index/problem_submit/compileinfo";
		$.post(url,{
			solution_id : solution_id,
		},function(data){
			$("#compileinfo").text(data);
		});
	});

	$("a.source").click(function(){
		var solution_id = $(this).parent().parent().find("#solution_id").text();
		var path = $("#hid_site").val();
		console.log(solution_id);
		//alert("11111");
		var url = path+"/oj_index/problem_submit/source";
		$.post(url,{
			solution_id : solution_id,
		},function(data){
			$("#source").text(data);
		});
	});
});