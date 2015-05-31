$(document).ready(function() {
	/*$("#pro_from").click(function(evt) {
		evt.preventDefault();
		 console.log($("#hid_id").val());
		 console.log($(this).val());
		 var url = $("#hid_site").val() + '/admin/contest/con_pro_list';
		$.post(url, {
				contest_id : $("#hid_id").val(),
				con_num :  $(this).val()
			}, function(data) {
		})
	});*/
	$("button.problem").click(function(event) {
		//console.log("jjjj");
		var problem_id = $(this).attr('id');
		var contest_id = $("#hid_id").val();
		var pro_num = $("#hid_num").val();
		var title = $(this).parent("td").parent("tr").find("td").eq(1).text();
		var url = $("#hid_site").val() + '/admin/contest/add_pro_list';
		//console.log(url);
		$.post(url, {
			contest_id : contest_id,
			pro_num : pro_num,
			problem_id : problem_id,
			title : title
		},function(data) {
			if(data == true) {
				alert("添加成功");
				var url1 = $("#hid_site").val() + '/admin/contest/con_pro_list/' + contest_id;
				window.location.href = url1; 
			} else {
				alert("添加失败!");
			}

		});
	});
	//返回按钮
	$("#back").click(function(event) {
		var contest_id = $("#hid_id").val();
		var url = $("#hid_site").val() + '/admin/contest/con_pro_list/' + contest_id;
		window.location.href = url; 
	});

	//搜索按钮
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

//按题目id查询
function search_id(search) {
    var regx = /^[0-9]*$/;
    if(!regx.test(search)) {
      alert("请输入正确题号");
      return 
    } else {
      var url = $("#hid_site").val() + '/admin/problem_search/search_problem_byId';
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
          td = $("<td>"+ "<button type='button'" + "id='"+ pro.problem_id +"' class='btn btn-primary problem' autocomplete='off' onClick = 'add(this.id)'><i class='icon-plus'></i>选择</button>"+ "</td>");
          td.appendTo(tr);
        }
      });
    }
}
//按题目标题查询
function search_title(search) {
      var url = $("#hid_site").val() + '/admin/problem_search/search_problem_byTitle';
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
          td = $("<td>"+ "<button type='button'" + "id='"+ pro.problem_id +"' class='btn btn-primary problem' autocomplete='off' onClick = 'add(this.id)'><i class='icon-plus'></i>选择</button>"+ "</td>");
          td.appendTo(tr);
        }
      });
}
//按题目分类查询
function search_class(search) {
  var url = $("#hid_site").val() + '/admin/problem_search/search_problem_byClass';
      $.post(url,{
        class_name : search
      },function(data) {
        if(data == false) {
          $("#tbody").html("");
          $("#links").remove();
          alert("抱歉没有找到");
        } else {
          var pro = eval("("+data+")");
          $("#tbody").html("");
          $("#links").remove();
          for(var i = 0; i < pro.length; i++) {
            var tr = $("<tr></tr>");
            tr.appendTo(tbody);
            td = $("<td>"+ pro[i].problem_id +"</td>");
            td.appendTo(tr);
            td = $("<td>"+ pro[i].title +"</td>");
            td.appendTo(tr);
            td = $("<td>"+ pro[i].class_name +"</td>");
            td.appendTo(tr);
            td = $("<td>"+ "<button type='button'" + "id='"+ pro[i].problem_id +"' class='btn btn-primary problem' autocomplete='off' onClick = 'add(this.id)'><i class='icon-plus'></i>选择</button>"+ "</td>");
            td.appendTo(tr);
          }
          goPage(1,3);
        }
      });
}

function goPage(pno,psize){

    var itable = document.getElementById("pro_table");
    var num = itable.rows.length;//表格行数
    var totalPage = 0;//总页数
    var pageSize = psize;//每页显示行数

    if((num-1)/pageSize > parseInt((num-1)/pageSize)) {   
        totalPage=parseInt((num-1)/pageSize)+1;   
    }else {   
        totalPage=parseInt((num-1)/pageSize);   
    }   

    var currentPage = pno;//当前页数
    var startRow = (currentPage - 1) * pageSize + 1;//开始显示的行   
    var endRow = currentPage * pageSize + 1;//结束显示的行   
    endRow = (endRow > num)? num : endRow;

    //前三行始终显示
    for(var i = 0; i < 1; i++) {
      var irow = itable.rows[i];
      irow.style.display = "block";
    }

    for(var i = 1; i < num; i++) {
      var irow = itable.rows[i];
      if(i >= startRow && i < endRow){
        irow.style.display = "block";
        //console.log(irow);
        var x = irow.cells;
        //console.log(x[0]);
        x[0].style.width="227px";
        x[1].style.width="508px";
        x[2].style.width="282px";
        x[3].style.width="113px";
      }else{
        irow.style.display = "none";
      }
    }

    var pageEnd = document.getElementById("pageEnd");
    var tempStr = "共"+(num-1)+"条记录 分"+totalPage+"页 当前第"+currentPage+"页";
    if(currentPage > 1){
      tempStr += "<a href=\"#\" onClick=\"goPage(" + (currentPage-1) + "," + psize + ") \">上一页</a>";
    }else{
      tempStr += "上一页"; 
    }

    if(currentPage<totalPage){
      tempStr += "<a href=\"#\" onClick=\"goPage(" + (currentPage+1) + "," + psize + ")\">下一页</a>";
    }else{
      tempStr += "下一页"; 
    }

    if(currentPage>1){
      tempStr += "<a href=\"#\" onClick=\"goPage(" + (1) + "," + psize + ")\">首页</a>";
    }else{
      tempStr += "首页";
    }

    if(currentPage<totalPage){
      tempStr += "<a href=\"#\" onClick=\"goPage("+(totalPage)+","+psize+")\">尾页</a>";
    }else{
      tempStr += "尾页";
    }
    document.getElementById("barcon").innerHTML = tempStr;

    var url = $("#hid_base").val() + 'application/views/admin/lib/bootstrap/css/bootstrap.min.css';
    //addSheetFile(url);
    //$.parser.parse(pro_table);
    $("#pro_table th:eq(0)").width(227);
    $("#pro_table th:eq(1)").width(508);
    $("#pro_table th:eq(2)").width(282);
    $("#pro_table th:eq(3)").width(113);
 
}

function add(pro_id) {
/*	$("button.problem").click(function(event) {*/
		//console.log("jjjj");
		var problem_id = pro_id;
		var contest_id = $("#hid_id").val();
		var pro_num = $("#hid_num").val();
		var title = $("#" + problem_id).parent("td").parent("tr").find("td").eq(1).text();
		var url = $("#hid_site").val() + '/admin/contest/add_pro_list';
		//console.log(url);
		$.post(url, {
			contest_id : contest_id,
			pro_num : pro_num,
			problem_id : problem_id,
			title : title
		},function(data) {
			if(data == true) {
				alert("添加成功");
				var url1 = $("#hid_site").val() + '/admin/contest/con_pro_list/' + contest_id;
				window.location.href = url1; 
			} else {
				alert("添加失败!");
			}

		});
/*	});*/
}