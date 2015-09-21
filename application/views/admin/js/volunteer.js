$(document).ready(function() {
		$("a[name='volunteer_del_a']").click(function() {
		var id = $(this).attr('id');
		var name = $(this).attr('data-name');
		//console.log(name);
		$("#volunteer_span").text(name);
		//alert(name);
		$("#volunteer_del_but").click(function() {
			/* Act on the event */
			var url = $("#hid_site").val() + '/admin/volunteer/volunteer_del';
			$.post(url,{
				id : id
			},function(data) {
				//alert(data);
				if(data == false) {
					alert("删除失败！");
				}else {
					self.location.reload();
				}
			});
		});
	});

		$("a[name='volunteer_edit_a']").click(function() {
			var id = $(this).attr('id');
			var name = $(this).attr('data-name');
			var url1 = $("#hid_site").val() + '/admin/volunteer/get_volunteer';
			$.post(url1,{
				id : id
			},function(data) {
				if(data == false) alert("出错啦！");
				else {
					var volunteer = eval("("+data+")");
					$("#v_span_name").text(volunteer.name);
					$("#start_edit").val(volunteer.start);
					$("#end_edit").val(volunteer.end);
					$("#hide_id").val(volunteer.id);
				}
			});

		});

		$("a[name='volunteer_edit_pwd']").click(function() {
			var id = $(this).attr('id');
			var name = $(this).attr('data-name');
			//console.log(name);
			$("#v1_span_name").text(name);
			$("#edit_id").val(id);
			//alert(name);
			/*$("#volunteer_del_but").click(function() {
				var url = $("#hid_site").val() + '/admin/volunteer/volunteer_edit_pwd';
				$.post(url,{
					id : id
					new_pwd : $("#new_pwd").val()
				},function(data) {
					if(data == false) {
						alert("修改失败！");
					}else {
						alert("修改成功！");
						self.location.reload();
					}
				});
			});*/
		});
});