
jQuery(document).ready(function() {

    var curPath = $("#hid_site").val();
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
        console.log(username);
        console.log(password);
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
        var url = curPath + '/oj_index/login/log_act';
        $.post(url,{
            username : username,
            password : password,
            captcha : captcha
        },function(data){
            if (data == 2) {
            //alert("验证码错误");
            $("#captcha_info").text('验证码错误');
            $("#captcha_img_r").click();
        } else if(data == false) {
          alert("用户名或密码错误");
          history.go(0);
        } else{
            window.location.href= curPath + '/oj_index/home/school_contest';
        }
        });
    });
    
    //注册验证码刷新
  $("#captcha_span_r").click(function(e){
    e.preventDefault();
    var url = curPath+'/oj_index/login/code';
    $("#captcha_img_r").attr("src",url);
  });
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
             var url = curPath+'/oj_index/register/username_check';
            $.ajax({
                url : url,
                type : 'POST',
                data : {username:username},
                asyns : false,
                success : function(data) {
                if (!data) {
                    $("#user_info_reg").text("用户名以存在");
                    $("#captcha_img_r").click();
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
        if(repeat_password == '') {
                $(this).parent().find('.repeat_password').focus();
                $(this).parent().find('.repeat_password').attr('placeholder', '请输入密码');
                $("#pass2_info").text("重复密码不能为空");
                return false;
        }
        if(password != repeat_password) {
                $(this).parent().find('.email').focus();
                $("#pass2_info").text("两次密码输入不一致");
            return false;
        }
        if(email == '') {
                $(this).parent().find('.email').focus();
                $(this).parent().find('.email').attr('placeholder', '请输入邮箱');
                $("#email_info").text("邮箱不能为空");
            return false;
        }
        if(email != ''){
            var Regx = /^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-.]+$/;
            if(!Regx.test(email)) {
                $(this).parent().find('.email').focus();
                $("#email_info").text('邮箱格式错误');
            return false;
            }
            var url = curPath+'/oj_index/register/email_check';
            $.ajax({
                url : url,
                type : 'POST',
                data : {email:email},
                async : false,
                success : function(data){
                    if(!data){
                    $(this).parent().find('.email').focus();
                    $("#email_info").text('邮箱已被注册');
                    $("#captcha_img_r").click();
                    em = true;
                }else
                    em = false;
                }
            })
            }
        if(captcha == '') {
                $(this).parent().find('.input-xlarge').focus();
                $(this).parent().find('.input-xlarge').attr('placeholder', '请输入验证码');
                $("#captcha_info_reg").text("请输入验证码");
                return false;
        }
            //console.log(em);
            if(chkreg()){
                    var url = curPath+'/oj_index/register/reg_act';
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
                    url = curPath+'/oj_index/login/code';
                    $("#captcha_img_r").click();
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
        var contest_id = $('[name="group"]:checked').val();
        var username = $(this).find('.username').val();
        var usernnum = $(this).find('.usernnum').val();
        var user1name = $(this).find('.user1name').val();
        var user1num = $(this).find('.user1num').val();
        var user2num = $(this).find('.user2num').val();
        var user2name = $(this).find('.user2name').val();
        var teamname = $(this).find('.teamname').val();
        var phone = $(this).find('.phone').val();
        var captcha = $(this).find('.input-xlarge').val();
        //console.log(contest_id);
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
            var url = curPath+'/oj_index/register/teamname_check';
            $.ajax({
                url : url,
                type : 'POST',
                data : {teamname:teamname,contest_id:contest_id},
                async : false,
                success : function(data){
                    if(!data){
                        //console.log(data);
                    $(this).parent().find('.teamname').focus();
                    $("#teamname_info").text("队伍名已存在");
                    $("#captcha_img_r").click();
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
        if(phone.length != 11 || !Regx.test(phone)) {
                $(this).parent().find('.phone').focus();
                $("#phone_info").text("手机号必须是11纯数字");
            return false;
        }
        if(captcha == '') {
                $(this).parent().find('.input-xlarge').focus();
                $(this).parent().find('.input-xlarge').attr('placeholder', '请输入验证码');
                $("#captch_info").text("验证码不能为空");
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
            var contest_name = $('[name="group"]:checked').next('span').html();
            var r = confirm('注意!!! 您选择的比赛类型是 ----'+ contest_name+'                 建议大一新生选择新生赛');
            if (r){
                var url = curPath+'/oj_index/register/enroll';
                $.post(url,{
                    cap_r : captcha,
                    username : username,
                    usernnum : usernnum,
                    user1num : user1num,
                    user1name : user1name,
                    user2num : user2num,
                    user2name : user2name,
                    phone : phone,
                    contest_id : contest_id,
                    teamname : teamname
                    },function  (data) {
                        if (data == true) {
                            alert('恭喜你！报名成功！');
                            console.log(phone);
                            history.go(0) ;
                        }else if(data == 2) {
                        alert('验证码不正确！');
                        $("#captcha_img_r").click();
                        //e.preventDefault();
                  } else {
                            //console.log(data);
                            alert('对不起！报名失败！');
                            //e.preventDefault();          
                        }
                    })
                }
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

     //检查报名时间是否合法
    $("#enroll").click(function(){
        //检查报名是否开始或者结束
      var start_time = Date.parse($("#pre_start_time").html());
      var end_time = Date.parse($("#pre_end_time").html());
      var timestamp1 = Date.parse(new Date(start_time))/1000;
      var timestamp2 = Date.parse(new Date(end_time))/1000;
      var now_time = Date.parse(new Date())/1000;
        //console.log(timestamp1);
        //console.log(timestamp2);
        //console.log(now_time);
         if(timestamp1 < now_time && timestamp2 > now_time){
                window.location.href= curPath + '/contest/school_contest/enroll';
        }else if(timestamp1 > now_time){
            alert("报名还没有开始,敬请期待");
        }
        else if(timestamp2 < now_time){
            alert("报名已经结束,如有问题请联系管理员");
            //$("#enroll_info").show();
            //$("#enroll_list").hide();
            window.location.href= curPath + '/contest/school_contest/enroll';
        }
    });
    //登录
     $('.page-container1 form .password').keyup(function(){
        $("#pass_info").text('');
    });
      $('.page-container1 form .username').keyup(function(){
        $("#user_info").text('');
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
    //报名
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
        $("#captch_info").text('');
    });
    $("#old, #new").click(function(){
        $("#teamname_info").text('');
        });
        
        //查看报名队伍
        $("#view_teams").click(function(){
            window.open(curPath + '/oj_index/home/teams' , "_blank");
        });
        
});
