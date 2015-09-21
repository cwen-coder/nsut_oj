$(document).ready(function() {
	$("a[name='balloon_del_a']").click(function() {
		var id = $(this).attr('id');
		var arr = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
		//alert(name);
		$("#balloon_span").text(arr[id-1]);
		$("#balloon_del_but").click(function() {
			/* Act on the event */
			var url = $("#hid_site").val() + '/admin/balloon/balloon_del';
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

	$("a[name='balloon_edit_a']").click(function() {
		var id = $(this).attr('id');
		var url1 = $("#hid_site").val() + '/admin/balloon/get_balloon';
		var arr = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
		$.post(url1,{
			id : id
		},function(data) {
			if(data == false) alert("出错啦！");
			else {
				var balloon = eval("("+data+")");
				$("#num_edit").val(arr[balloon.id-1]);
				$("#hide_num").val(balloon.id);
				$("#color_edit").val(balloon.color);
			}
		});

	});
});