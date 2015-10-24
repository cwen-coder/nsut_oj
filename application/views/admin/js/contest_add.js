/*(function($) {  
    $.fn.watch = function(callback) {  
        return this.each(function() {  
            //缓存以前的值  
            $.data(this, 'originVal', $(this).val());  
  
            //event  
            $(this).on('keyup paste', function() {  
                var originVal = $(this, 'originVal');  
                var currentVal = $(this).val();  
  
                if (originVal !== currentVal) {  
                    $.data(this, 'originVal', $(this).val());  
                    callback(currentVal);  
                }  
            });  
        });  
    }  
})(jQuery);*/  
var check_title = false;
var check_num = true;
var check_pwd = true;
var check_start_time = false;
var check_end_time = false;
function chksub() {
	if(check_title && check_num && check_pwd && check_start_time && check_end_time) {
		$("#con_add").removeAttr('disabled');
	} else {
		$("#con_add").attr('disabled','true');
	}
}
$(document).ready(function() {
	$("#class_sel").bind('change', function() {
		var val = $(this).val();
		//console.log(val);
		switch (val) {
			case '1': $("#div_pwd").hide();
					  $("#con_pwd").val("");
					  $("#p_s_time").hide();
					  $("#p_s_time").val("");
					  $("#p_e_time").hide();
					  $("#p_e_time").val("");
					  $("#medal").hide();
					  $("#gold").val("");
					  $("#silver").val("");
					  $("#copper").val("");
					  check_pwd = true;
					  chksub();
					  break;
			case '2': $("#div_pwd").css("display","inline");
					  $("#div_pwd").show();
					  $("#p_s_time").hide();
					  $("#p_s_time").val("");
					  $("#p_e_time").hide();
					  $("#p_e_time").val("");
					  $("#medal").hide();
					  $("#gold").val("");
					  $("#silver").val("");
					  $("#copper").val("");
					  check_pwd = false;
					  chksub();
					  break;
			case '3': $("#div_pwd").hide();
					  $("#con_pwd").val("");
					  $("#p_s_time").css("display","inline");
					  $("#p_e_time").css("display","inline");
					  $("#p_s_time").show();
					  $("#p_e_time").show();
					  $("#medal").show();
					  check_pwd = true;
					  chksub();
					  break;
			case '4': $("#div_pwd").hide();
					  $("#con_pwd").val("");
					  $("#p_s_time").css("display","inline");
					  $("#p_e_time").css("display","inline");
					  $("#p_s_time").show();
					  $("#p_e_time").show();
					  $("#medal").show();
					  check_pwd = true;
					  chksub();
					  break;
		}
	});
	//console.log($("#class_sel").val());
	//检查比赛标题
	$("#con_title").bind('input propertychange blur',function() {
		//console.log("djjj");
		var len = ($(this).val()).length;
		if(len == 0) {
			$("#con_title_span").text('标题不能为空');
			check_title = false;
			chksub();
		} else {
			$("#con_title_span").text('');
			check_title = true;
			chksub();
		}
	});

	//检查题目总数
	$("#con_num").bind('input propertychange blur', function() {
		var num = $(this).val();
		//console.log(num);
		var leg = num.length;
		var regx = /^[0-9]*$/;
		if(leg != 0) {
			if(!regx.test(num)) {
				$("#con_num_span").text('  请输入数字组合');
				check_num = false;
				chksub();
			} else {
				$("#con_num_span").text('');
				check_num = true;
				chksub();
			}
		} else {
			$("#con_num_span").text('');
			check_num = true;
			chksub();
		}
	});
	
	//密码检查
	$("#con_pwd").bind('input propertychange blur', function() {
		var sel = $("#class_sel").val();
		//console.log(sel);
		if(sel == 2) {
			var pwd = $("#con_pwd").val();
			var len = pwd.length;
			if(len == 0) {
				$("#con_pwd_span").text('私有类型密码不能为空');
				check_pwd = false;
				chksub();
			} else {
				$("#con_pwd_span").text('');
				check_pwd = true;
				chksub();
			}
		}
	});

	//开始时间检测
	$("#start_time").bind('input propertychange blur', function() {
		var start_time = $(this).val();
		//console.log(start_time);
		if(start_time.length == 0) {
			$("#con_s_t_span").text('不正确');
			$("#div_end").css('margin-left','8%');
			check_start_time = false;
			chksub();
		} else {
			$("#con_s_t_span").text('');
			$("#div_end").css('margin-left','12%');
			check_start_time = true;
			chksub();
		}
	});

	//结束时间检测
	$("#end_time").bind('input propertychange blur', function() {
		var end_time = $(this).val();
		//console.log(start_time);
		if(end_time.length == 0) {
			$("#con_e_t_span").text('不正确');
			check_end_time = false;
			chksub();
		} else {
			$("#con_e_t_span").text('');
			check_end_time = true;
			chksub();
		}
	});
});

