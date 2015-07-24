$(document).ready(function(){
	$("#user_search_but").click(function() {
		/* Act on the event */
		var username = $("#user_search").val();
		if(username.length == 0) {
			$("#user_table").hide();
			$("#h1_info").text('不能为空！');
		} else {
			var url = $("#hid_site").val() + '/admin/acmer/user_search';
			$.post(url, {
				username: username
			}, function(data) {
				//alert(data);
				if(data == false) {
					/*var con = $("<h2>用户不存在！</h2>");
					con.appendTo(tbody);*/
					$("#user_table").hide();
					$("#h1_info").text('用户不存在！');
					$("#h1_info").show();
					$("#oj_form").hide();
					$("#modal-body").css('height','80px');
				} else {
					var user = eval("("+data+")");
					//$("#tbody").html("");
					$("#h1_info").hide();
					$("#user_table").show();
					$("#oj_form").hide();
					$("#modal-body").css('height','180px');
					/*var tr = $("<tr></tr>");
	          		tr.appendTo(tbody);
	          		td = $("<td>"+ user.username +"</td>");
	          		td.appendTo(tr);
	          		td = $("<td>"+ user.solved +"</td>");
	          		td.appendTo(tr);
	          		td = $("<td>"+ user.reg_time +"</td>");
	          		td.appendTo(tr);
	          		td = $("<td>添加</td>");
	          		td.appendTo(tr);*/
	          		$("td#username").html(user.username);
	          		$("td#solved").html(user.solved);
	          		$("td#reg_time").html(user.reg_time);
	          		$("#acmer_add_act").attr('name',user.user_id);
				}
			});
		}
		//console.log(username);
		
	});

	$("#acmer_add_act").click(function() {
		var user_id = $(this).attr('name');
		var username = $("#username").html();

		//alert(username);
		var url = $("#hid_site").val() + '/admin/acmer/user_check';
		$.post(url,{
			user_id:user_id
		},function(data) {
			//alert(data);
			if(data == false) {
				alert("该用户已是acmer！");
			}else {
				$("#modal-body").css('height','460px');
				$("#oj_form").show();
				$("#hide_user_id").val(user_id);
				$("#hide_user_name").val(username);
			}
		});
	});

	$("a[name='acmer_del_a']").click(function() {
		var name = $(this).attr('id');
		//alert(name);
		$("#acmer_del_but").click(function() {
			/* Act on the event */
			var url = $("#hid_site").val() + '/admin/acmer/acmer_del';
			$.post(url,{
				name : name
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

	$("a[name='acmer_edit_a']").click(function() {
		var name = $(this).attr('id');
		var url1 = $("#hid_site").val() + '/admin/acmer/acmer_info';
		$.post(url1,{
			name : name
		},function(data) {
			if(data == false) alert("出错啦！");
			else {
				var acmer = eval("("+data+")");
				$("#acmer_name").val(acmer.name);
				$("#hide_acmer_name").val(acmer.name);
				$("#poj_name_edit").val(acmer.poj_name);
				$("#hdoj_name_edit").val(acmer.hdoj_name);
				$("#cf_name_edit").val(acmer.cf_name);

			}
		});

	});
});