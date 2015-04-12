var uname = false;
var pas1 = false;
var pas2 = false;
var ema = false;

function chkreg(){  
    	if(uname && pas1 && pas2 && ema){  
      		$("#reg_sub").removeAttr('disabled');  
   	 }  
}  
$(document).ready(function() {
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
  		 	$.post("/nsut_oj/index.php/oj_index/register/username_check",{
  		 			username:name
  		 		},function(data) {
  		 			console.log(data);
  		 		if (data) {
  		 			//console.log(data);
  		 			$("#cname").text('输入正确');
  		 			uname = true;
  		 			chkreg();		 			
  		 		}else {
  		 			$("#cname").text('用户名已存在');
  		 		}
  		 	})
  		 }
 	 });

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
 	 		$("#pass1").text('输入正确');
 	 		pas1 = true;
 	 		chkreg();
 	 	}
 	 });
 	 $("#password2").blur(function() {
 	 	var password = $("#password2").val();
 	 	//console.log(password);
 	 	if (password.length == 0) {
 	 		$("#pass2").text('密码不能为空');;
 	 	}else if (password == $("#password1").val()) {
 	 		$("#pass2").text('输入正确');
 	 		pas2 = true;
 	 		chkreg();
 	 	}else {
 	 		$("#pass2").text('两次密码不一致');
 	 	}
 	 });
 	 $("#email").blur(function() {
 	 	var email = $("#email").val();
 	 	var Regx = /^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-.]+$/;
 	 	//var Regx =  /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
 	 	if(email.length == 0) {
 	 		$("#email1").text('邮箱不能为空');
 	 	}else if (!Regx.test(email)){
 	 		$("#email1").text('请输入正确的邮箱');
 	 	}else {
 	 		$.post('/nsut_oj/index.php/oj_index/register/email_check', {
 	 			email:email
 	 		}, function(data) {
 	 			if(data) {
 	 				$("#email1").text('输入正确');
 	 				ema = true;
 	 				chkreg();
 	 			}else {
 	 				$("#email1").text('邮箱已被注册');
 	 			}
 	 		});
 	 	}
 	 });
 	 //uname = true;
 	 $("#reg_form").submit(function(e) {  
 	 	//e.preventDefault();
 	 	$.post("/nsut_oj/index.php/oj_index/register/reg_act",{
 	 		username : $("#r_username").val(),
 	 		password1 : $("#password1").val(),
 	 		password2 : $("#password2").val(),
 	 		email : $("#email").val()
 	 	},function  (data) {
 	 		alert(data);
 	 		if(data) {
 	 			alert('恭喜你！注册成功！');
 	 			$("#reg_sub").attr("disabled",true);
 	 		}else {
 	 			alert('对不起！注册失败！');
 	 			//e.preventDefault();
 	 			$("#reg_sub").attr("disabled",true);   			
 	 		}
 	 	})

  	  });  
});
function formReset()
{
	document.getElementById("reg_form").reset();
}