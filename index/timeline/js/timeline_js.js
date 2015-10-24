// JavaScript Document
function logo_opacity_focus()
{
	$('#logo').animate({opacity:1.0},500);	
}
function logo_opacity_blur()
{
	$('#logo').animate({opacity:0.8},500);	
}
function time_now_slide()
{
	$('#time a').css('color','#CCC');
	$('#time_now').css('color','#6EB8D3');
	$('#time_side_cover').animate({top:'25px'},1500);	
}
function time_2014_slide()
{
	$('#time a').css('color','#CCC');
	$('#time_2014').css('color','#6EB8D3');
	$('#time_side_cover').animate({top:'30px'},1500);	
}
function time_2013_slide()
{
	$('#time a').css('color','#CCC');
	$('#time_2013').css('color','#6EB8D3');
	$('#time_side_cover').animate({top:'40px'},1500);	
}
function time_2012_slide()
{
	$('#time a').css('color','#CCC');
	$('#time_2012').css('color','#6EB8D3');
	$('#time_side_cover').animate({top:'50px'},1500);	
}
function time_2011_slide()
{
	$('#time a').css('color','#CCC');
	$('#time_2011').css('color','#6EB8D3');
	$('#time_side_cover').animate({top:'76px'},1500);	
}
function time_2010_slide()
{
	$('#time a').css('color','#CCC');
	$('#time_2010').css('color','#6EB8D3');
	$('#time_side_cover').animate({top:'102px'},1500);	
}
function check_time(time)
{
	if(time<10)
	{
		time = '0'+time;	
	}
	return time;
}

function get_time()
{
	var week = ['日','一','二','三','四','五','六'];
	var now = new Date();
	var hours = now.getHours();
	var minutes	= now.getMinutes();
	var seconds = now.getSeconds();
	var year = now.getFullYear();
	
	var month = now.getMonth();
	month ++;
	var date = now.getDate();
	var day = now.getDay();
	minutes = check_time(minutes);
	seconds = check_time(seconds);
	$('#clock').html('<s style="border-right-color:#fff;"></s><h3>' + year + '年'+month+'月'+date+'日 星期'+week[day]+'</h3><p>TIME&nbsp;'+hours+':'+minutes+':'+seconds+'</p>');
	setTimeout('get_time()',500);
}
function time_float()
{
	var top = $('#time').offset().top;
	$(window).scroll(
		function()
		{
				var offsetTop = top + $(window).scrollTop() + 'px';
				$('#time').css({top:offsetTop});		
		}
	);	
}
function day_number(year,month,date)
{
	month--;
	var day_ms = 1000*60*60*24;
	var day_now = new Date();
	var day_past = new Date(year,month,date);
	var day_num = ((day_now.getTime())-(day_past.getTime()))/day_ms;
	day_num = parseInt(day_num);
	document.write(day_num);
}
