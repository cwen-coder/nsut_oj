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
function chksub() {
	if(check_title) {
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
					  $("#gold").val("");
					  $("#silver").val("");
					  $("#copper").val("");
					  break;
			case '2': $("#div_pwd").css("display","inline");
					  $("#div_pwd").show();
					  $("#p_s_time").hide();
					  $("#p_s_time").val("");
					  $("#p_e_time").hide();
					  $("#p_e_time").val("");
					  $("#gold").val("");
					  $("#silver").val("");
					  $("#copper").val("");
					  break;
			case '3': $("#div_pwd").hide();
					  $("#con_pwd").val("");
					  $("#p_s_time").css("display","inline");
					  $("#p_e_time").css("display","inline");
					  $("#p_s_time").show();
					  $("#p_e_time").show();
					  $("#medal").show();
					  break;
			case '4': $("#div_pwd").hide();
					  $("#con_pwd").val("");
					  $("#p_s_time").css("display","inline");
					  $("#p_e_time").css("display","inline");
					  $("#p_s_time").show();
					  $("#p_e_time").show();
					  $("#medal").show();
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
		var leg = num.length;
		var regx = "/^[0-9]*$/";
		//if(leg == 0)
	})
});

