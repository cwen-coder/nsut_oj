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
});