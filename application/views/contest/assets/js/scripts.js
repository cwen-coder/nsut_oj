
jQuery(document).ready(function() {
    var curPath = $("#hid_site").val() + '/oj_index';
        var em = false;
        var um = false;

    //登录
    $('.page-container1 form').submit(function(evt){
        evt.preventDefault();
        var username = $(this).find('.username').val();
        var password = $(this).find('.password').val();
        var captcha = $(this).find('.input-xlarge').val();
        if(captcha == undefined) captcha = "undefined";
        console.log(captcha);
        if(username == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '27px');
                $(this).parent().find('.username').attr('placeholder', '请输入用户名');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.username').focus();
            });
            return false;
        }
        if(captcha == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '165px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.input-xlarge').focus();
                $(this).parent().find('.input-xlarge').attr('placeholder', '请输入验证码');
            });
            return false;
        }
        if(password == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '96px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.password').focus();
                $(this).parent().find('.password').attr('placeholder', '请输入密码');
            });
            return false;
        }
        
        var url = curPath + '/login/log_act';
        $.post(url,{
            username : username,
            password : password,
            captcha : captcha
        },function(data){
            if (data == 2) {
            $("#captcha_c").text('验证码错误');
            //$("#captcha_img").attr("src",url);
        } else if(data == false) {
          alert("用户名或密码错误");
          url = curPath+'/login/code';
          $("#captcha_img").attr("src",url);
        } else {
            //console.log(data);
          history.go(0);
        }
        });
    });
    
    //注册验证码刷新
  $("#captcha_span_r").on("click",function(e){
    e.preventDefault();
    var url = curPath+'/login/code';
    $("#captcha_img_r").attr("src",url);
    //$("#captcha_img").attr("src","../login/code");
    // alert("123")
  })
    //注册------------------------------------------------------------------------------------------------------------------------
    $('.page-container2 form').submit(function(evt){
        evt.preventDefault();
        var username = $(this).find('.username').val();
        var password = $(this).find('.password').val();
        var repeat_password = $(this).find('.repeat_password').val();
        var captcha = $(this).find('.input-xlarge').val();
        var email = $(this).find('.email').val();
        console.log(repeat_password);

        if(username == '') {
                $(this).parent().find('.username').attr('placeholder', '请输入用户名');
                $(this).parent().find('.username').focus();
                $("#user_info_reg").text("用户名不能为空");
                return false;
        }
        if(username != ''){
            var Regx = /^[A-Za-z0-9]*$/;
            if(username.length < 6){
                $(this).parent().find('.username').focus();
                $("#user_info_reg").text("用户名不能少于6个字符");
                return false;
            }
            if(username.length >32) {
                $(this).parent().find('.username').focus();
                $("#user_info_reg").text("用户名不能大于32个字符");
                return false;
            }
            if(!Regx.test(username)){
                $(this).parent().find('.username').focus();
                $("#user_info_reg").text("必须为字母或数字组合");
                return false;
            }
             var url = curPath+'/register/username_check';
            $.ajax({
                url : url,
                type : 'POST',
                data : {username:username},
                asyns : false,
                success : function(data) {
                if (!data) {
                    $("#user_info_reg").text("用户名以存在");
                    um = true;
                }else
                        um = false;
            }
        });
    }
        if(password == '') {
                $(this).parent().find('.password').focus();
                $(this).parent().find('.password').attr('placeholder', '请输入密码');
                $("#pass1_info").text("密码不能为空");
                return false;
        }
        if(repeat_password == '') {
                $(this).parent().find('.repeat_password').focus();
                $(this).parent().find('.repeat_password').attr('placeholder', '请输入密码');
                $("#pass2_info").text("重复密码不能为空");
                return false;
        }
        if(email == '') {
                $(this).parent().find('.email').focus();
                $(this).parent().find('.email').attr('placeholder', '请输入邮箱');
                $("#email_info").text("邮箱不能为空");
            return false;
        }
        if(captcha == '') {
                $(this).parent().find('.input-xlarge').focus();
                $(this).parent().find('.input-xlarge').attr('placeholder', '请输入验证码');
                $("#captcha_info_reg").text("请输入验证码");
                return false;
        }
        if(password != repeat_password) {
                $(this).parent().find('.email').focus();
                $("#pass2_info").text("两次密码输入不一致");
            return false;
        }
        if(password != '') {
            if(password.length<6){
                $(this).parent().find('.password').focus();
                $("#pass1_info").text("密码不能小于6位");
            }
            if(password.length>32) {
                $(this).parent().find('.password').focus();
                $("#pass1_info").text("密码不能大于32位");
            }
        }
        if(email != ''){
            var Regx = /^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-.]+$/;
            if(!Regx.test(email)) {
                $(this).parent().find('.email').focus();
                $("#email_info").text('邮箱格式错误');
            return false;
            }
            var url = curPath+'/register/email_check';
            $.ajax({
                url : url,
                type : 'POST',
                data : {email:email},
                async : false,
                success : function(data){
                    if(!data){
                    $(this).parent().find('.email').focus();
                    $("#email_info").text('邮箱已被注册');
                    em = true;
                }else
                    em = false;
                }
            })
            }
            console.log(em);
            if(chkreg()){
                    var url = curPath+'/register/reg_act';
                $.post(url,{
                    cap_r : captcha,
                    username : username,
                    password1 : password,
                    password2 : repeat_password,
                    email : email
                    },function  (data) {
                        if (data == true) {
                            alert('恭喜你！注册成功！');
                            history.go(0) ;
                        }else if(data == 2) {
                    alert('验证码不正确！');
                    //e.preventDefault();
                  } else {
                            alert('对不起！注册失败！');
                            //e.preventDefault();          
                        }
                    })
            }
            function chkreg(){  
                        if(!em && !um)
                            return true;
                        else
                            return false;
            }
    });
        //报名--------------------------------------------------------------------------------------------------------------------------
        $('.page-container3 form').submit(function(evt){
            evt.preventDefault();
        var contest_class = $('[name="group"]:checked').val();
        var username = $(this).find('.username').val();
        var usernnum = $(this).find('.usernnum').val();
        var user1name = $(this).find('.user1name').val();
        var user1num = $(this).find('.user1num').val();
        var user2num = $(this).find('.user2num').val();
        var user2name = $(this).find('.user2name').val();
        var teamname = $(this).find('.teamname').val();
        var phone = $(this).find('.phone').val();
        var captcha = $(this).find('.input-xlarge').val();
        //console.log(captcha);
        var Regx = /^[0-9]*$/ ;
        if(usernnum == '') {
                $(this).parent().find('.usernnum').focus();
                $(this).parent().find('.usernnum').attr('placeholder', '请输入队长学号');
                $("#usernum_info").text("队长学号不能为空");
            return false;
        }
        if(usernnum.length !=9 || !Regx.test(usernnum)){
                $(this).parent().find('.usernnum').focus();
                $("#usernum_info").text("学号必须是9为纯数字");
            return false;
        }
        if(username == '') {
                $(this).parent().find('.username').focus();
                $(this).parent().find('.username').attr('placeholder', '请输队长姓名');
                $("#username_info").text("队长姓名不能为空");
            return false;
        }
        if(teamname == '') {
                $(this).parent().find('.teamname').focus();
                $(this).parent().find('.teamname').attr('placeholder', '请输入队伍名');
                $("#teamname_info").text("队伍名不能为空");
            return false;
        }
        if(teamname != ''){
            var url = curPath+'/register/teamname_check';
            $.ajax({
                url : url,
                type : 'POST',
                data : {teamname:teamname},
                async : false,
                success : function(data){
                    if(!data){
                        console.log(data);
                    $(this).parent().find('.teamname').focus();
                    $("#teamname_info").text("队伍名已存在");
                    em = true;
                }else
                    em = false;
                }
            })
        }
        if(phone == '') {
                $(this).parent().find('.phone').focus();
                $(this).parent().find('.phone').attr('placeholder', '请输入联系方式');
                $("#phone_info").text("手机号不能为空");
            return false;
        }
        if(captcha == '') {
                $(this).parent().find('.input-xlarge').focus();
                $(this).parent().find('.input-xlarge').attr('placeholder', '请输入验证码');
                $("#captch_info").text("验证码不能为空");
            return false;
        }
        if(phone.length != 11 || !Regx.test(phone)) {
                $(this).parent().find('.phone').focus();
                $("#phone_info").text("手机号必须是11纯数字");
            return false;
        }
        if(user1num != ''){
            if(user1num.length !=9 || !Regx.test(user1num)) {
                    $(this).parent().find('.user1num').focus();
                    $("#user1num_info").text("学号不合法");
                return false;
            }
            if(user1name == ''){
                    $(this).parent().find('.user1name').focus();
                    $("#user1name_info").text("姓名不能为空");
                    return false;
            }
        }
        if(user2num != ''){
            if(user2num.length !=9 || !Regx.test(user2num)) {
                    $(this).parent().find('.user2num').focus();
                    $("#user2num_info").text("学号不合法");
                    return false;
            }
            if(user2name == ''){
                    $(this).parent().find('.user2name').focus();
                    $("#user2name_info").text("姓名不能为空");
                    return false;
            }
        }
        if(!em){
                var url = curPath+'/register/enroll';
                $.post(url,{
                    cap_r : captcha,
                    username : username,
                    usernnum : usernnum,
                    user1num : user1num,
                    user1name : user1name,
                    user2num : user2num,
                    user2name : user2name,
                    phone : phone,
                    contest_class : contest_class,
                    teamname : teamname
                    },function  (data) {
                        if (data == true) {
                            alert('恭喜你！报名成功！');
                            history.go(0) ;
                        }else if(data == 2) {
                    alert('验证码不正确！');
                    //e.preventDefault();
                  } else {
                            alert('对不起！报名失败！');
                            //e.preventDefault();          
                        }
                    })
        }


    });
    //登录注册切换
    $("#register").click(function(){
            //$("page-container2").find("div").show();
            $(".page-container2").show();
            //$("#page-container2").show();
            $(".page-container1").hide();
            //alert($("page-container2").style);
    });

     //报名/参赛列表 切换
    $("#enroll").click(function(){
            $("#enroll_info").show();
            $("#enroll_list").hide();
    });

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
        //page-container3
    $('.page-container3 form .username').keyup(function(){
        $("#username_info").text('');
    });
    $('.page-container3 form .usernnum').keyup(function(){
        $("#usernum_info").text('');
    });
    $('.page-container3 form .user1name').keyup(function(){
        $("#user1name_info").text('');
    });
    $('.page-container3 form .user1num').keyup(function(){
        $("#user1num_info").text('');
    });
    $('.page-container3 form .user2num').keyup(function(){
        $("#user2num_info").text('');
    });
    $('.page-container3 form .user2name').keyup(function(){
        $("#user2name_info").text('');
    });
    $('.page-container3 form .teamname').keyup(function(){
        $("#teamname_info").text('');
    });
    $('.page-container3 form .phone').keyup(function(){
        $("#phone_info").text('');
    });
    $('.page-container3 form .input-xlarge').keyup(function(){
        $("#captcha_span_r").text('');
    });
    $('.page-container1 form .username, .page-container1 form .password').keyup(function(){

    });

});
