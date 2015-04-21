$(document).ready(function() {
	$("#A_captcha_span").on("click",function(e){
    e.preventDefault();
    $("#A_captcha_img").attr("src","../privilege/code");
    // alert("123")
  });
	$("#log_but_A").click(function(e) {
        //alert("odsfo");
        e.preventDefault();
     $.post("../privilege/log_act",{
        username : $("#A_username").val(),
        password : $("#A_password").val(),
        captcha : $("#A_captcha").val()
     },function (data) {
        //console.log (data);
        if (data == 2) {
            alert('验证码错误');
        } else if(data == false) {
          alert("用户名或密码错误");
          $("#A_captcha_img").attr("src","../privilege/code");
        } else {
          //history.go(0);
          window.location.href="../home/index";          
        }
     })
   });
});
