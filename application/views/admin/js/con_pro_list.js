$(document).ready(function() {
	$("a[href='#myModal']").click(function() {
		var source = $(this).parent().parent().find("input").val();
		var problem_id = $(this).parent().parent().find("input").attr('id');
		//console.log(problem_id);
		var num_M = $(this).parent("td").parent("tr").find("td").eq(0).text();
		var num = $(this).parent("td").parent("tr").find("td").eq(0).attr('id');
		var contest_id = $("#hid_id").val();
		$("#problem_span").text(num_M);
		$("#problem_but_del").click(function() {
			var url = $("#hid_site").val() + '/admin/contest/del_con_pro';
			$.post(url, {
				contest_id : contest_id,
				num : num,
				source : source,
				problem_id : problem_id
			}, function(data) {
				//console.log(data);
				if(data == true) {
					alert("删除成功");
					self.location.reload();
				} else {
					alert("删除失败");
				}
			});
		});
	});
	$("a[href='#myModal_edit']").click(function(){
		/*var pid = $(this).parent().parent().find("input").val();
		console.log(pid);*/
		alert("禁止修改来自题库的题目");
	});
});