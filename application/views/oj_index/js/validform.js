var uname = false;
var pas1 = false;
var pas2 = false;
var ema = false;
var cap_r = false;
var usern = false;
var pad = false;
var cap = false;
//获取目录地址
/*var curPath=window.location.href;
curPath = curPath.split("/");
curPath.pop();
curPath.pop();*/
//console.log(curPath);

//注册按钮检查
function chkreg(){  
    	if(uname && pas1 && pas2 && ema && cap_r){  
      		$("#reg_sub").removeAttr('disabled');  
   	 } else {
      $("#reg_sub").attr("disabled",true);
     }
}  
//登录按钮检查
function chklog() {
  if (usern && pad && cap) {
    $("#log_sub").removeAttr('disabled'); 
  }
}

$(document).ready(function() {

  var curPath = $("#hid_site").val() + '/oj_index';
  //点击刷新验证码
  $("#captcha_span").on("click",function(e){
    e.preventDefault();
    //console.log(curPath);
    var url = curPath+'/login/code';
    $("#captcha_img").attr("src",url);
    //$("#captcha_img").attr("src","../login/code");
    // alert("123")
  })

  //注册验证码刷新
  $("#captcha_span_r").on("click",function(e){
    e.preventDefault();
    var url = curPath+'/login/code';
    $("#captcha_img_r").attr("src",url);
    //$("#captcha_img").attr("src","../login/code");
    // alert("123")
  })

  //检验用户名
 	 $("#r_username").bind('input propertychange blur',function() {
  		 var name = $("#r_username").val();
  		 var len = name.length;
  		  var Regx = /^[A-Za-z0-9]*$/;
  		// console.log(name);
  		 if (len == 0 ) {
  		 	$("#cname").text('用户名不能为空');
        uname = false;
        chkreg(); 
  		 }else if (!Regx.test(name)) {
  		 	$("#cname").text('必须为字母与数字组合');
        uname = false;
        chkreg(); 
  		 }else if (len < 6) {
  		 	$("#cname").text('用户名不能少于6个字符');
        uname = false;
        chkreg(); 
  		 }else if (len > 32) {
  		 	$("#cname").text('用户名不能超过32个字符');
        uname = false;
        chkreg(); 
  		 }else {
        var url = curPath+'/register/username_check';
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
            uname = false;
            chkreg(); 
  		 		}
  		 	})
  		 }
 	 });

   //检验第一次输入密码
 	 $("#password1").bind('input propertychange blur',function() {
 	 	var password = $("#password1").val();
 	 	var len = password.length;
 	 	//console.log(password);
 	 	if (len == 0 ) {
 	 		$("#pass1").text('密码不能为空');
      pas1 = false;
      chkreg();
 	 	}else if (len < 6) {
 	 		$("#pass1").text('密码不能少于6个字符');
      pas1 = false;
      chkreg();
 	 	}else if (len > 30) {
 	 		$("#pass1").text('密码不能超过32个字符');
       pas1 = false;
        chkreg();
 	 	}else {
 	 		$("#pass1").text('');
 	 		pas1 = true;
 	 		chkreg();
 	 	}
 	 });

   //检验第二次输入的密码
 	 $("#password2").bind('input propertychange blur',function() {
 	 	var password = $("#password2").val();
 	 	//console.log(password);
 	 	if (password.length == 0) {
 	 		$("#pass2").text('密码不能为空');
      pas2 = false;
      chkreg();
 	 	}else if (password == $("#password1").val()) {
 	 		$("#pass2").text('');
 	 		pas2 = true;
 	 		chkreg();
 	 	}else {
 	 		$("#pass2").text('两次密码不一致');
      pas2 = false;
      chkreg();
 	 	}
 	 });

   //检验邮箱
 	 $("#email").bind('input propertychange blur',function() {
 	 	var email = $("#email").val();
 	 	var Regx = /^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-.]+$/;
 	 	//var Regx =  /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
 	 	if(email.length == 0) {
 	 		$("#email1").text('邮箱不能为空');
      ema = false;
      chkreg();
 	 	}else if (!Regx.test(email)){
 	 		$("#email1").text('请输入正确的邮箱');
      ema = false;
      chkreg();
 	 	}else {
       var url = curPath+'/register/email_check';
 	 		$.post(url, {
 	 			email:email
 	 		}, function(data) {
 	 			if(data) {
 	 				$("#email1").text('');
 	 				ema = true;
 	 				chkreg();
 	 			}else {
 	 				$("#email1").text('邮箱已被注册');
           ema = false;
            chkreg();
 	 			}
 	 		});
 	 	}
 	 });
   //注册检验验证码
   $("#captcha_r").bind('input propertychange blur',function() {
       var pass = $("#captcha_r").val();
       if(pass.length == 0) {
        $("#captcha_c").text('请输入验证码');
        cap_r = false;
        chkreg();
       } else {
        $("#captcha_c").text('');
        cap_r = true;
        chkreg();
        //chklog();
       }
   });
 	 //uname = true;
   //
   //注册动作
 	 $("#reg_sub").click(function(e) {  
 	 	//e.preventDefault();
    var url = curPath+'/register/reg_act';
 	 	$.post(url,{
      cap_r : $("#captcha_r").val(),
 	 		username : $("#r_username").val(),
 	 		password1 : $("#password1").val(),
 	 		password2 : $("#password2").val(),
 	 		email : $("#email").val()
 	 	},function  (data) {
 	 		//alert(data);
      //console.log(data);
 	 		if (data == true) {
 	 			alert('恭喜你！注册成功！');
 	 			$("#reg_sub").attr("disabled",true);
        history.go(0) ;
 	 		}else if(data == 2) {
        alert('验证码不正确！');
        //e.preventDefault();
        $("#reg_sub").attr("disabled",true);   
      } else {
 	 			alert('对不起！注册失败！');
 	 			//e.preventDefault();
 	 			$("#reg_sub").attr("disabled",true);   			
 	 		}
 	 	})

  	  }); 


   //登录检验用户名
   $("#username").bind('input propertychange blur',function() {
       var name = $("#username").val();
       if(name.length == 0) {
        $("#username_c").text('请输入用户名');
          usern = false;
          chklog();  
       } else {
        //alert("dsfih");
        $("#username_c").text('');
        usern = true;
        chklog();      
       }
   });

   //登录检验密码
   $("#password").bind('input propertychange blur',function() {
       var pass = $("#password").val();
       if (pass.length == 0) {
        $("#password_c").text('请输入密码');
        pad = false;
        chklog();  
       } else {
        $("#password_c").text('');
        pad = true;
        chklog();     
       }
   });

   //登录检验验证码
   $("#captcha").bind('input propertychange blur',function() {
       var pass = $("#captcha").val();
       if(pass.length == 0) {
        $("#captcha_c").text('请输入验证码');
        cap = false;
        chklog();
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
    var url = curPath+'/login/log_act';
     $.post(url,{
        username : $("#username").val(),
        password : $("#password").val(),
        captcha : $("#captcha").val()
     },function (data) {
        //console.log (data);
        if (data == 2) {
            $("#captcha_c").text('验证码错误');
            //$("#captcha_img").attr("src",url);
        } else if(data == false) {
          alert("用户名或密码错误");
          url = curPath+'/login/code';
          $("#captcha_img").attr("src",url);
        } else {
          history.go(0);
        }
     })
   });

  //登录页注册按钮
  $("#log_sub_reg").click(function() {
    /* Act on the event */
    $("#login_close").click();
    $("#register").click();
  });
});

//重置动作
function formReset()
{
	document.getElementById("reg_form").reset();
}
