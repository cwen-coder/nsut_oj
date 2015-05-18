
$(document).ready(function() {

    //获取点击删除模态框的所在行的id
    $('a[href*="#myModal"]').click(function() {
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

    $("#search_but").click(function() {
       var search = $("#search").val();
       if(search.length == 0) {
        alert("请输入搜索关键字");
       } else {
          var checked = $('input:radio[name="search"]:checked').val();
          if(checked == 1) {
            search_id(search);
          } else if(checked == 2) {
            search_title(search);
          } else {
            search_class(search);
          }
       }
    });
    
});

function search_id(search) {
    var regx = /^[0-9]*$/;
    if(!regx.test(search)) {
      alert("请输入正确题号");
      return 
    } else {
      var url = $("#hid_site").val() + '/admin/problem/search_problem_byId';
      $.post(url, {
        problem_id : search
      },function(data) {
        if(data == false) {
          alert("请输入正确题号");
        }else if(data == 1) {
          $("#tbody").html("");
          $("#links").remove();
          alert("抱歉没有找到");
        } else {
          var pro = eval("("+data+")");
          $("#tbody").html("");
          $("#links").remove();
          var tr = $("<tr></tr>");
          tr.appendTo(tbody);
          td = $("<td>"+ pro.problem_id +"</td>");
          td.appendTo(tr);
          td = $("<td>"+ pro.title +"</td>");
          td.appendTo(tr);
          td = $("<td>"+ pro.class_name +"</td>");
          td.appendTo(tr);
          var url_ed = $("#hid_site").val() + '/admin/problem/pro_edit/' + pro.problem_id;
          td = $("<td>"+ "<a href='" + url_ed + "'><i class='icon-pencil'></i></a>" +
           "  <a href='#myModal' role='button' data-toggle='modal' id = '" + pro.problem_id + "'><i class='icon-remove'></i></a>" 
           + "</td>");
          td.appendTo(tr);
        }
      });
    }
}

function search_title(search) {
      var url = $("#hid_site").val() + '/admin/problem/search_problem_byTitle';
      $.post(url,{
        title : search
      },function(data) {
        if(data == false) {
          $("#tbody").html("");
          $("#links").remove();
          alert("抱歉没有找到");
        } else {
          var pro = eval("("+data+")");
          $("#tbody").html("");
          $("#links").remove();
          var tr = $("<tr></tr>");
          tr.appendTo(tbody);
          td = $("<td>"+ pro.problem_id +"</td>");
          td.appendTo(tr);
          td = $("<td>"+ pro.title +"</td>");
          td.appendTo(tr);
          td = $("<td>"+ pro.class_name +"</td>");
          td.appendTo(tr);
          var url_ed = $("#hid_site").val() + '/admin/problem/pro_edit/' + pro.problem_id;
          td = $("<td>"+ "<a href='" + url_ed + "'><i class='icon-pencil'></i></a>" +
           "  <a href='#myModal' role='button' data-toggle='modal' id = '" + pro.problem_id + "'><i class='icon-remove'></i></a>" 
           + "</td>");
          td.appendTo(tr);
        }
      });
}