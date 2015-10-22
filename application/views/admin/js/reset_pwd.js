$(document).ready(function() {
	$("#reset_user").click(function(event) {
		$("#pro_con_div").show();
		$('#pro_div').hide();
		$('#s_pro_div').hide();
		$(this).closest('li').addClass('active');
		$(this).closest('li').next().removeClass('active');
		$(this).closest('li').next().next().removeClass('active');
	});

	$('#reset_team').click(function(event) {
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
});