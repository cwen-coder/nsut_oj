$(document).ready(function() {
	//$("#"+contest_id).click();
	/*$("a.con_a").click(function(eve) {
		//alert("ksfh");
		 //console.log("hfhdh");
		try{ 
            eve.preventDefault();  // 非 IE 浏览器
        }catch(e){
            eve.returnValue = false;  // IE8.0 及其以下版本
        }
        var contest_id = $(this).attr('id');
        var url = $("#hid_site").val() + '/contest/home/index';
        $.post(url, {
			contest_id : contest_id
		},function(data) {
			//console.log(data);
			if(data == 0) {
				$("#signin").click();
			} 
		});
	});*/
	$("#con_password").bind('input propertychange blur',function() {
		var con_pwd = $(this).val();
		if(con_pwd.length != 0) {
			$("#con_log_sub").removeAttr('disabled');
			//console.log($("#con_password").val());
		} else {
			$("#con_log_sub").attr("disabled",true);
		}
	});
	$("#con_log_sub").click(function() {
		/* Act on the event */
		var curPath=window.location.href;
		curPath = curPath.split("/");
		var contest_id = curPath.pop();
		//console.log( contest_id);
		var url = $("#hid_site").val() + '/contest/home/con_log_act';
		//console.log(contest_id);
		$.post(url,{
			con_pwd : $("#con_password").val(),
			contest_id : contest_id
		},function(data){
			//console.log(data);
			if(data == true) {
				//location.reload();
				$("#con_login_close").click();
				//location.reload();
				//alert(contest_id);
				document.getElementById(contest_id).click();
				//$("a#"+contest_id).click();
			} else {
				alert("密码不正确!");
			}
		});
	});
});