
jQuery(document).ready(function() {

    $('.page-container1 form').submit(function(){
        var username = $(this).find('.username').val();
        var password = $(this).find('.password').val();
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
    });

    $("#register").click(function(){
        alert("11111");
    });

    $('.page-container1 form .username, .page-container1 form .password').keyup(function(){
        $(this).parent().find('.error').fadeOut('fast');
    });

});
