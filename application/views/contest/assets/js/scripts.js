
jQuery(document).ready(function() {

    var curPath = $("#hid_site").val();
    //注册验证码刷新
    $("#captcha_span_r_").click(function(e){
    e.preventDefault();
    var url = curPath+'/oj_index/login/code';
    $("#captcha_img_r_").attr("src",url);
  });
    //登录
    $('.page form').submit(function(evt){
        evt.preventDefault();
        var username = $(this).find('.username').val();
        var password = $(this).find('.password').val();
        var captcha = $(this).find('.input-xlarge').val();
        if(captcha == undefined) captcha = "undefined";
        //console.log(captcha);
        //console.log(username);
        //console.log(password);
        if(username == '') {
                $(this).parent().find('.username').attr('placeholder', '请输入用户名');
                $(this).parent().find('.username').focus();
                $("#user_info").text("用户名不能为空");
            return false;
        }
        if(password == '') {
                $(this).parent().find('.password').focus();
                $(this).parent().find('.password').attr('placeholder', '请输入密码');
                $("#pass_info").text("请输入密码");
            return false;
        }
        if(captcha == '') {
                $(this).parent().find('.input-xlarge').focus();
                $(this).parent().find('.input-xlarge').attr('placeholder', '请输入验证码');
                $("#captcha_info").text("请输入验证码");
            return false;
        }
        if($("#enter").val() == undefined)
                var url = curPath + '/oj_index/login/log_act';
         else 
                var url = curPath + '/contest/school_contest/school_login';
        $.post(url,{
            username : username,
            password : password,
            captcha : captcha
        },function(data){
            if (data == 2) {
            alert("验证码错误");
            $("#captcha_info").text('验证码错误');
            $("#captcha_img_r").click();
        } else if(data == false) {
          alert("用户名或密码错误");
         $("#captcha_img_r").click();
        } else{
            //alert(1111);
            //console.log(data);
            window.location.href= curPath + '/oj_index/home/school_contest';
        }
        });
    });
    var uname = false;
    var pas1 = false;
    var pas2 = false;
    var ema = false;
    var cap_r = false;
    //注册按钮检查
        function chkreg(){  
    	if(uname && pas1 && pas2 && ema && cap_r){  
      		$("#enroll_button").removeAttr('disabled');
                                   $("#enroll_button").addClass("button1");
                                   return true;
   	 }else {
                        $("#reg_sub").attr("disabled",true);
                        return false;
                  }
         }  
         $("#username").blur(function() {
         var name = $("#username").val();
         var len = name.length;
         var Regx = /^[A-Za-z0-9]*$/;
         if(name.length == 0) {
            $("#user_info_reg").text("请输入用户名");
            usern = false;
            chkreg();  
        } 
         if (len == 0 ) {
            $("#user_info_reg").text('用户名不能为空');
            uname = false;
            chkreg(); 
         }else if (!Regx.test(name)) {
                $("#user_info_reg").text('必须为字母与数字组合');
                uname = false;
                chkreg(); 
        }else if (len < 6) {
                $("#user_info_reg").text('用户名不能少于6个字符');
                uname = false;
                chkreg(); 
        }else if (len > 32) {
                $("#user_info_reg").text('用户名不能超过32个字符');
                uname = false;
                chkreg(); 
        }else {
                 var url = curPath+'/oj_index/register/username_check';
                $.post(url,{
  	username:name
  	},function(data) {
  	//console.log(data);
                    if (data) {
  	//console.log(data);
                    $("#user_info_reg").text('');
                    uname = true;
                    chkreg();		 			
                    }else {
                        $("#user_info_reg").text('用户名已存在');
                        uname = false;
                        chkreg(); 
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
 	 		 $("#pass1_info").text('密码不能为空');
                                                    pas1 = false;
                                                    chkreg();
 	 	}else if (len < 6) {
 	 		 $("#pass1_info").text('密码不能少于6个字符');
                                                    pas1 = false;
                                                    chkreg();
 	 	}else if (len > 30) {
 	 		 $("#pass1_info").text('密码不能超过32个字符');
                                                    pas1 = false;
                                                    chkreg();
 	 	}else {
 	 		 $("#pass1_info").text('');
 	 		pas1 = true;
 	 		chkreg();
 	 	}
 	 });

                    //检验第二次输入的密码
 	 $("#password2").blur(function() {
 	 	var password = $("#password2").val();
 	 	//console.log(password);
 	 	if (password.length == 0) {
 	 		$("#pass2_info").text('重复密码不能为空');
                                                    pas2 = false;
                                                    chkreg();
 	 	}else if (password == $("#password1").val()) {
 	 		$("#pass2_info").text('');
 	 		pas2 = true;
 	 		chkreg();
 	 	}else {
 	 		$("#pass2_info").text('两次密码不一致');
                                                    pas2 = false;
                                                    chkreg();
 	 	}
 	 });

                    //检验邮箱
 	 $("#email").blur(function() {
 	 	var email = $("#email").val();
 	 	var Regx = /^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-.]+$/;
 	 	//var Regx =  /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
 	 	if(email.length == 0) {
 	 		$("#email_info").text('邮箱不能为空');
                                                    ema = false;
                                                    chkreg();
 	 	}else if (!Regx.test(email)){
 	 		$("#email_info").text('请输入正确的邮箱');
                                                    ema = false;
                                                    chkreg();
 	 	}else {
                                                    var url = curPath+'/oj_index/register/email_check';
 	 		$.post(url, {
 	 			email:email
 	 		}, function(data) {
 	 			if(data) {
 	 				$("#email_info").text('');
 	 				ema = true;
 	 				chkreg();
 	 			}else {
 	 				$("#email_info").text('邮箱已被注册');
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
        $("#captcha_info_reg").text('请输入验证码');
        cap_r = false;
        chkreg();
       } else {
        $("#captcha_info_reg").text('');
        cap_r = true;
        chkreg();
        //chklog();
       }
   });
    
    //注册------------------------------------------------------------------------------------------------------------------------
    $('.page2 form').submit(function(evt){
        evt.preventDefault();
            if(chkreg()){
                    var url = curPath+'/oj_index/register/reg_act';
                $.post(url,{
                   cap_r : $("#captcha_r").val(),
 	 username : $("#username").val(),
 	 password1 : $("#password1").val(),
 	 password2 : $("#password2").val(),
 	 email : $("#email").val()
                    },function  (data) {
                        if (data == true) {
                            alert('恭喜你！注册成功！');
                            history.go(0) ;
                        }else if(data == 2) {
                    alert('验证码不正确！');
                    url = curPath+'/oj_index/login/code';
                    $("#captcha_img_r_").click();
                    //e.preventDefault();
                  } else {
                            alert('对不起！注册失败！');
                            //e.preventDefault();          
                        }
                    })
            }
    });
    //登录注册切换
    $("#register").click(function(){
            //$("page-container2").find("div").show();
            $(".page2").show();
            //$("#page-container2").show();
            $(".page").hide();
            //alert($("page-container2").style);
    });

   
    //登录
     $('.page-container1 form .password').keyup(function(){
        $("#pass_info").text('');
    });
      $('.page-container1 form .username').keyup(function(){
        $("#user_info").text('');
    });
    $('.page-container1 form .input-xlarge').keyup(function(){
        $("#captcha_info").text('');
    });
      //注册
    $('.page-container2 form .password').keyup(function(){
        $("#pass1_info").text('');
    });
    $('.page-container2 form .username').keyup(function(){
        $("#user_info_reg").text('');
    });
    $('.page-container2 form .repeat_password').keyup(function(){
        $("#pass2_info").text('');
    });
    $('.page-container2 form .email').keyup(function(){
        $("#email_info").text('');
    });
    $('.page-container2 form .captcha').keyup(function(){
        $("#captcha_info_reg").text('');
    });
    
        
        
           //检查报名是否开始或者结束
//      var start_time = Date.parse($("#pre_start_time").html());
//      var end_time = Date.parse($("#pre_end_time").html());
//      var timestamp1 = Date.parse(new Date(start_time))/1000;
//      var timestamp2 = Date.parse(new Date(end_time))/1000;
//      var now_time = Date.parse(new Date())/1000;
          //检查报名时间是否合法
    $("#enroll").click(function(){
        //console.log(timestamp1);
        //console.log(timestamp2);
        //console.log(now_time);
        window.open(curPath + '/contest/school_contest/enroll' , "_self");
//         if(timestamp1 < now_time && timestamp2 > now_time){
//             alert('success');
//                 window.open(curPath + '/contest/school_contest/enroll' , "_self");
//        }else if(timestamp1 > now_time){
//            alert("报名还没有开始,敬请期待");
//        }
//        else if(timestamp2 < now_time){
//            alert("报名已经结束,如有问题请联系管理员");
//            //$("#enroll_info").show();
//            //$("#enroll_list").hide();
//            //window.location.href= curPath + '/contest/school_contest/enroll';
//        }
    });
        //查看报名队伍
        $("#view_teams").click(function(){
             window.open(curPath + '/oj_index/home/teams' , "_blank");
        });
        //updata_info
        $("#updata_info").click(function(){
             window.open(curPath + '/contest/school_contest/updata_enroll' , "_self");
//            if(timestamp1 < now_time && timestamp2 > now_time){
//               window.location.href= curPath + '/contest/school_contest/updata_enroll';
//        }else if(timestamp1 > now_time){
//            alert("报名还没有开始,敬请期待");
//        }
//        else if(timestamp2 < now_time){
//            alert("报名已经结束,如有问题请联系管理员");
//            //window.location.href= curPath + '/contest/school_contest/enroll';
//        }
        });
        //点击进入比赛
        $("#enter_contest").click(function(){
                window.location.href= curPath + '/contest/contest/school_pro_list';
//           console.log(password);
        });
        //点击进入比赛look_contest
        $("#look_contest").click(function(){
                window.location.href= curPath + '/contest/contest/rank';
//           console.log(password);
        });
});
