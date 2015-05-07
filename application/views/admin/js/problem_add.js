//UEditor实例化编辑器到不同的id上
var desc = UE.getEditor('container1');
var sample_in = UE.getEditor('container2');
var sample_out = UE.getEditor('container3');
var hint = UE.getEditor('container4');


$(document).ready(function() {
	//题号验证
	$("#problem_id").blur(function() {
		var problem_id = $(this).val();
		//console.log(problem_id);
	});
});