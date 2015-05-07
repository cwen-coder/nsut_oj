$(function(){
	$('a[herf*="#myDelete"]').click(function(){
		$('#problem_category').text($(this).attr("id"););
	});
});