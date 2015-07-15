
jQuery(document).ready(function() {
    var curPath = $("#hid_site").val() + '/oj_index';
    $('.page-container1 form').submit(function(){
        var username = $(this).find('.username').val();
        var password = $(this).find('.password').val();
        var captcha = $(this).find('.input-xlarge').val();
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
        
        /*var url = curPath + '/login/log_act';
        $.post(url,{
            username : $("#username").val(),
            password : $("#password").val()
        },function(data){
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
        });*/
    });
    $('.page-container2 form').submit(function(){
        var username = $(this).find('.username').val();
        var password = $(this).find('.password').val();
        var repeat_password = $(this).find('.repeat_password').val();
        var email = $(this).find('.email').val();
        console.log(repeat_password);
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
        if(repeat_password == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '165px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.repeat_password').focus();
                $(this).parent().find('.repeat_password').attr('placeholder', '请输入密码');
            });
            return false;
        }
        if(email == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '243px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.email').focus();
                $(this).parent().find('.email').attr('placeholder', '请输入邮箱');
            });
            return false;
        }
        if(password != repeat_password) {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '165px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.email').focus();
                $("#pass_info").text("两次密码输入不一致");
            });
            return false;
        }
    });


    $("#register").click(function(){
            //$("page-container2").find("div").show();
            $(".page-container2").show();
            //$("#page-container2").show();
            $(".page-container1").hide();
            //alert($("page-container2").style);
    });

    $('.page-container1 form .username, .page-container1 form .password').keyup(function(){
        $(this).parent().find('.error').fadeOut('fast');
    });
    $('.page-container2 form .username, .page-container2 form .password, .page-container2 form .repeat_password, .page-container2 form .email').keyup(function(){
        $(this).parent().find('.error').fadeOut('fast');
    });

});
