$(document).ready(function() {
    $('a[href*="#myModal"').click(function() {
      $("#problem_span").text($(this).attr("id"));
    });


    $('#problem_but_del').click(function(){
      var pro_id = $("#problem_span").text();
      //console.log(pro_id);
      $.post("../problem_del", {
      	problem_id : pro_id
      },function(e) {
      		if(e) {
      			alert("删除成功！");
      			self.location.reload();
      		}
      		else alert("删除失败！");
      })
    })
});