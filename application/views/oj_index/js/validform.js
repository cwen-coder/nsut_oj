$(document).ready(function() {
	var uname = false;
	var pas1 = false;
	var pas2 = false;
	var ema = false;
 	 $("#r_username").blur(function(){
  		 var name = $("#r_username").val();
  		  var Regx = /^[A-Za-z0-9]*$/;
  		// console.log(name);
  		 if(name.length == 0 ){
  		 	$("#cname").text('用户名不能为空');
  		 }else if(!Regx.test(name)){
  		 	$("#cname").text('输入存在非法字符');
  		 }	 else if(name.length < 6){
  		 	$("#cname").text('用户名不能少于六个字符');
  		 }else if(name.length > 18){
  		 	$("#cname").text('用户名过长');
  		 }else{
  		 	$.post("/nsut_oj/index.php/oj_index/register/username_post",{
  		 			username:name
  		 		},function(data){
  		 			//console.log(data);
  		 		if(data == 0){
  		 			console.log(data);
  		 			$("#cname").text('用户名可用');
  		 			uname = true;	
  		 		}else {
  		 			$("#cname").text('用户名已存在');
  		 		}
  		 	})
  		 }
 	 });
 	 $("#password1").blur(function() {
 	 	//var password = $（
 	 });
});