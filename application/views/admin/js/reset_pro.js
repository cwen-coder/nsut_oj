$(document).ready(function() {
	$("#pro_con").click(function(event) {
		/* Act on the event */
		/*pro_0
		solution_id
		pro_con_div
		pro_div
		s_pro_div*/

		$("#pro_con_div").show();
		$('#pro_div').hide();
		$('#s_pro_div').hide();
		/*$(this).addClass('active');
		$('#pro_0').removeClass('active');
		$('#solution_id').removeClass('active');*/
		$(this).closest('li').addClass('active');
		$(this).closest('li').next().removeClass('active');
		$(this).closest('li').next().next().removeClass('active');
	});

	$('#pro_0').click(function(event) {
		/* Act on the event */

		$("#pro_con_div").hide();
		$('#pro_div').show();
		$('#s_pro_div').hide();
		/*$('#pro_con').removeClass('active');
		$('#solution_id').removeClass('active');
		$(this).addClass('active');*/
		$(this).closest('li').addClass('active');
		$(this).closest('li').prev().removeClass('active');
		$(this).closest('li').next().removeClass('active');
	});

	$('#solution_id').click(function(event) {
		/* Act on the event */
		//alert("djj");
		$("#pro_con_div").hide();
		$('#pro_div').hide();
		$('#s_pro_div').show();
		/*$('#pro_con').removeClass('active');
		$('#pro_0').removeClass('active');
		$(this).addClass('active');
*/
		$(this).closest('li').addClass('active');
		$(this).closest('li').prev().removeClass('active');
		$(this).closest('li').prev().prev().removeClass('active');
	});

	$("#contest_id").bind('input propertychange blur',function() {
		
		var contest_id = $(this).val();
		//console.log(contest_id);
		var url = $("#hide_site").val() + '/admin/reset_problem/ajax_con_pro' ;
		//console.log(url);
		$.post(url,{
			contest_id:contest_id
		},function(data) {
			data = eval("("+data+")");
			//console.log(data);
			$('#con_pro_id option').remove();
			var len = data.pro.length;
			//console.log(len);
			//var sel = document.getElementByid('con_pro_id');
			for(var i = 0; i < len; i++) {
				//console.log(value);
				if(data.pro[i] != null) {
					//sel.options.add(new Option("name","id"));
					var value = data.pro[i].problem_id;
					//console.log(value);
					var text = data.arr[data.pro[i].num];
					$("#con_pro_id").append("<option value='"+value+"'>"+text+"</option>");
				}
			}
		});
	});
});