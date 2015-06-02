$(document).ready(function() {
	$("a[href='#myModal']").click(function() {
		var num_M = $(this).parent("td").parent("tr").find("td").eq(0).text();
		var num = $(this).parent("td").parent("tr").find("td").eq(0).attr('id');
		var contest_id = $("#hid_id").val();
		$("#problem_span").text(num_M);
		$("#problem_but_del").click(function() {
			var url = $("#hid_site").val() + '/admin/contest/del_con_pro';
			$.post(url, {
				contest_id : contest_id,
				num : num
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
});