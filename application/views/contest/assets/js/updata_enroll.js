jQuery(document).ready(function() {

    var curPath = $("#hid_site").val();
        var em = false;
        var um = false;
        
         //参赛类型初始化
         
    
        //注册验证码刷新
  $("#captcha_span_r").click(function(e){
    e.preventDefault();
    var url = curPath+'/oj_index/login/code';
    $("#captcha_img_r").attr("src",url);
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
        if(contest_id== null){
            alert('请选择参赛类型');
            return false;
        }
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
                var url = curPath+'/contest/school_contest/updata_action';
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
                            alert('恭喜你！修改成功！');
                            //console.log(phone);
                            history.go(-1) ;
                        }else if(data == 2) {
                        alert('验证码不正确！');
                        //$("#captcha_img_r").click();
                        $("#captcha_img_r").click();
                        //e.preventDefault();
                  } else {
                            //console.log(data);
                            alert('对不起！修改失败！');
                            $("#captcha_img_r").click();
                            //e.preventDefault();          
                        }
                    })
                }
        }
    });
    
        //报名修改
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
   
})