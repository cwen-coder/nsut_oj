$(document).ready(function() {
	//点击回复按钮
	$("a[rel='reply']").click(function() {
		//console.log("nbnnnn");
		var name = $(this).attr('name');
		$("div[name="+name+"]").show();
		$("button[name='ans_que_ok']").click(function() {
			var url = $("#hid_site").val() + '/admin/ans_que/admin_ans_que';
			$.post(url,{
				que_id : name,
				content : $("textarea#"+name).val()
			},function(data) {
				if(data == true) {	
					self.location.reload();
				} else {
					alert('回复失败！');
				}
			});
		});
	});

	//点击取消按钮
	$("a[rel='reply_off']").click(function() {
		//console.log("nbnnnn");
		$(this).closest("div").hide();
	});

	//点击删除按钮
	$("a[rel='delete']").click(function() {
		$('#myModal').modal('show');
		var ask_id = $(this).attr('name');
		//console.log(ask_id);
		$("#hid_ask_id").val(ask_id);
		$("#del_ask_que").click(function() {
			var url = $("#hid_site").val() + '/admin/ans_que/del_ask_que';
			$.post(url,{
				ask_id : ask_id
			},function(data) {
				if(data == true) {
					alert("删除成功");
					self.location.reload();
				} else {
					alert("删除失败");
				}
			});
		});
	});

	//点击已回复
	$("#ans_que_sum").click(function() {
		$("#no_ans_que_well").hide();
		$("#ans_que_well").show();
		$(this).closest('li').addClass('active');
		$(this).closest('li').prev().removeClass('active');
		
	});

	//点击未回复
	$("#no_ans_que").click(function() {
		$("#ans_que_well").hide();
		$("#no_ans_que_well").show();
		$(this).closest('li').addClass('active');
		$(this).closest('li').next().removeClass('active');
		
	});

	//点击删除回复
	$("a[rel='delete_ans']").click(function() {
		$('#myModal_ans').modal('show');
		var id = $(this).attr('name');
		var que_id = $(this).attr('question');
		//console.log(ask_id);
		//$("#hid_ask_id").val(ask_id);
		$("#del_ask_ans").click(function() {
			var url = $("#hid_site").val() + '/admin/ans_que/del_ask_ans';
			$.post(url,{
				id : id,
				que_id : que_id
			},function(data) {
				if(data == true) {
					alert("删除成功");
					self.location.reload();
					//$("#ans_que_sum").click();
				} else {
					alert("删除失败");
				}
			});
		});
	});
	
});