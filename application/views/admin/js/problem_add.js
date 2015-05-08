//UEditor实例化编辑器到不同的id上
var desc = UE.getEditor('container1');
var sample_in = UE.getEditor('container2');
var sample_out = UE.getEditor('container3');
var hint = UE.getEditor('container4');
//
var check_id = false;
var check_title = false;
function chksub() {
	if(check_id && check_title) {
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
					$("#problem_id_span").text('*');
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
			$("#pro_title_span").text('*');
			check_title = true;
			chksub();
		}
	});
	
});