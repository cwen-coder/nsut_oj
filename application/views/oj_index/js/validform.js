var uname = false;
var pas1 = false;
var pas2 = false;
var ema = false;
var usern = false;
var pad = false;
var cap = false;
//获取目录地址
var curPath=window.location.href;
curPath = curPath.split("/");
curPath.pop();
curPath.pop();
curPath = curPath.join("/");
//console.log(curPath);

//注册按钮检查
function chkreg(){  
    	if(uname && pas1 && pas2 && ema){  
      		$("#reg_sub").removeAttr('disabled');  
   	 }  
}  
//登录按钮检查
function chklog() {
  if (usern && pad && cap) {
    $("#log_sub").removeAttr('disabled'); 
  }
}

$(document).ready(function() {
  //点击刷新验证码
  $("#captcha_span").on("click",function(e){
    e.preventDefault();
    var url = curPath+'/oj_index/login/code';
    $("#captcha_img").attr("src",url);
    //$("#captcha_img").attr("src","../login/code");
    // alert("123")
  })

  //检验用户名
 	 $("#r_username").blur(function() {
  		 var name = $("#r_username").val();
  		 var len = name.length;
  		  var Regx = /^[A-Za-z0-9]*$/;
  		// console.log(name);
  		 if (len == 0 ) {
  		 	$("#cname").text('用户名不能为空');
  		 }else if (!Regx.test(name)) {
  		 	$("#cname").text('必须为字母与数字组合');
  		 }else if (len < 6) {
  		 	$("#cname").text('用户名不能少于6个字符');
  		 }else if (len > 32) {
  		 	$("#cname").text('用户名不能超过32个字符');
  		 }else {
        var url = curPath+'/oj_index/register/username_check';
  		 	$.post(url,{
  		 			username:name
  		 		},function(data) {
  		 			//console.log(data);
  		 		if (data) {
  		 			//console.log(data);
  		 			$("#cname").text('');
  		 			uname = true;
  		 			chkreg();		 			
  		 		}else {
  		 			$("#cname").text('用户名已存在');
  		 		}
  		 	})
  		 }
 	 });

   //检验第一次输入密码
 	 $("#password1").blur(function() {
 	 	var password = $("#password1").val();
 	 	var len = password.length;
 	 	//console.log(password);
 	 	if (len == 0 ) {
 	 		$("#pass1").text('密码不能为空');
 	 	}else if (len < 6) {
 	 		$("#pass1").text('密码不能少于6个字符');
 	 	}else if (len > 30) {
 	 		$("#pass1").text('密码不能超过32个字符');
 	 	}else {
 	 		$("#pass1").text('');
 	 		pas1 = true;
 	 		chkreg();
 	 	}
 	 });

   //检验第二次输入的密码
 	 $("#password2").blur(function() {
 	 	var password = $("#password2").val();
 	 	//console.log(password);
 	 	if (password.length == 0) {
 	 		$("#pass2").text('密码不能为空');;
 	 	}else if (password == $("#password1").val()) {
 	 		$("#pass2").text('');
 	 		pas2 = true;
 	 		chkreg();
 	 	}else {
 	 		$("#pass2").text('两次密码不一致');
 	 	}
 	 });

   //检验邮箱
 	 $("#email").blur(function() {
 	 	var email = $("#email").val();
 	 	var Regx = /^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-.]+$/;
 	 	//var Regx =  /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
 	 	if(email.length == 0) {
 	 		$("#email1").text('邮箱不能为空');
 	 	}else if (!Regx.test(email)){
 	 		$("#email1").text('请输入正确的邮箱');
 	 	}else {
       var url = curPath+'/oj_index/register/email_check';
 	 		$.post(url, {
 	 			email:email
 	 		}, function(data) {
 	 			if(data) {
 	 				$("#email1").text('');
 	 				ema = true;
 	 				chkreg();
 	 			}else {
 	 				$("#email1").text('邮箱已被注册');
 	 			}
 	 		});
 	 	}
 	 });
 	 //uname = true;
   //
   //注册动作
 	 $("#reg_sub").click(function(e) {  
 	 	//e.preventDefault();
    var url = curPath+'/oj_index/register/reg_act';
 	 	$.post(url,{
 	 		username : $("#r_username").val(),
 	 		password1 : $("#password1").val(),
 	 		password2 : $("#password2").val(),
 	 		email : $("#email").val()
 	 	},function  (data) {
 	 		//alert(data);
      //console.log(data);
 	 		if (data) {
 	 			alert('恭喜你！注册成功！');
 	 			$("#reg_sub").attr("disabled",true);
        history.go(0) ;
 	 		}else {
 	 			alert('对不起！注册失败！');
 	 			//e.preventDefault();
 	 			$("#reg_sub").attr("disabled",true);   			
 	 		}
 	 	})

  	  }); 


   //登录检验用户名
   $("#username").blur(function() {
       var name = $("#username").val();
       if(name.length == 0) {
        $("#username_c").text('请输入用户名');

       } else {
        //alert("dsfih");
        $("#username_c").text('');
        usern = true;
        chklog();      
       }
   });

   //登录检验密码
   $("#password").blur(function() {
       var pass = $("#password").val();
       if (pass.length == 0) {
        $("#password_c").text('请输入密码');
        
       } else {
        $("#password_c").text('');
        pad = true;
        chklog();     
       }
   });

   //登录检验验证码
   $("#captcha").blur(function() {
       var pass = $("#captcha").val();
       if(pass.length == 0) {
        $("#captcha_c").text('请输入验证码');
       } else {
        $("#captcha_c").text('');
        cap = true;
        chklog();
        //chklog();
       }
   });

   //登录动作
   $("#log_sub").click(function() {
    //console.log("odsfo");
    var url = curPath+'/oj_index/login/log_act';
     $.post(url,{
        username : $("#username").val(),
        password : $("#password").val(),
        captcha : $("#captcha").val()
     },function (data) {
        //console.log (data);
        if (data == 2) {
            $("#captcha_c").text('验证码错误');
        } else if(data == false) {
          alert("用户名或密码错误");
          url = curPath+'/oj_index/login/code';
          $("#captcha_img").attr("src",url);
        } else {
          history.go(0);
        }
     })
   });
});

//重置动作
function formReset()
{
	document.getElementById("reg_form").reset();
}
