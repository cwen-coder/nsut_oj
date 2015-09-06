$(document).ready(function() {
		$("#A_captcha_span").on("click",function(e){
    		e.preventDefault();
     		var url = $("#hide_site").val() +'/admin/privilege/code';
    		$("#A_captcha_img").attr("src",url);
    		// alert("123")
  		});


		$("#log_but_A").click(function(e) {
	        //alert("odsfo");
	        e.preventDefault();
	        var site_url = $("#hide_site").val();
	        var url = site_url + '/volunteer/privilege/log_act';
	        var url_ = site_url +'/admin/privilege/code';
	        var url1 = site_url + '/volunteer/home/index';
	     $.post(url,{
	        username : $("#A_username").val(),
	        password : $("#A_password").val(),
	        captcha : $("#A_captcha").val()
	     },function (data) {
	        //console.log (data);
	        if (data == 2) {
	            alert('验证码错误');
	        } else if(data == false) {
	          alert("用户名或密码错误");
	          $("#A_captcha_img").attr("src",url_);
	        } else {
	          //history.go(0);
	          window.location.href=url1;          
	        }
	     })
	   });

});