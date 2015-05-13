//UEditor实例化编辑器到不同的id上
var content_des = UE.getEditor('content_des');
var content_input = UE.getEditor('content_input');
var content_output = UE.getEditor('content_output');
var hint = UE.getEditor('hint');
//
var check_id = false;
var check_title = false;
var check_time_limit = false;
var check_memory_limit = false;
function chksub() {
	if(check_id && check_title && check_time_limit && check_memory_limit) {
		$("#pro_add").removeAttr('disabled');
	}
}

$(document).ready(function() {
	//题号验证
	$("#problem_id").blur(function() {
		var problem_id = $(this).val();
		//console.log(problem_id);
		var len = problem_id.length;
		var regx = /^[0-9]*$/;
		if(len == 0) {
			$("#problem_id_span").text('题号不能为空');
		}else if(!regx.test(problem_id)) {
			$("#problem_id_span").text('请输入正确的题号');
		}else if(len > 5) {
			$("#problem_id_span").text('输入题号过长');
		}else {
			$.post("../problem/check_id",{
				problem_id:problem_id
			},function(data){
				//console.log(data);
				if(data) {
					$("#problem_id_span").text('');
					check_id = true;
					chksub();
				} else {
					$("#problem_id_span").text('题号重复');
				}
			})
		}
	});

	//检查题目标题
	$("#pro_title").blur(function() {
		var len = ($(this).val()).length;
		if(len == 0) {
			$("#pro_title_span").text('标题不能为空');
		} else {
			$("#pro_title_span").text('');
			check_title = true;
			chksub();
		}
	});

	//检查时间限制
	$("#time_limit").blur(function() {
		var len = ($(this).val()).length;
		var regx = /^[0-9]*$/;
		//alert(len);
		if(len == 0) {
			$("#time_limit_span").text('时间限制不能为空');
		} else if(!regx.test($(this).val())) {
			$("#time_limit_span").text('请输入正确的时间限制');
		} else {
			$("#time_limit_span").text('');
			check_time_limit = true;
			chksub();
		}
	});


	//检查内存限制
	$("#memory_limit").blur(function() {
		var len = ($(this).val()).length;
		var regx = /^[0-9]*$/;
		//alert(len);
		if(len == 0) {
			$("#memory_limit_span").text('内存限制不能为空');
		} else if(!regx.test($(this).val())) {
			$("#memory_limit_span").text('请输入正确的时内存限制');
		} else {
			$("#memory_limit_span").text('');
			check_memory_limit = true;
			chksub();
		}
	});
	
});