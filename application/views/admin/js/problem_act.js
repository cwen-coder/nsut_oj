$(document).ready(function() {

    //获取点击删除模态框的所在行的id
    $('a[href*="#myModal"').click(function() {
      $("#problem_span").text($(this).attr("id"));
    });

    //相应删除按钮
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
    });

    
    
});