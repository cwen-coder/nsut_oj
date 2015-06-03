$(document).ready(function() {
	goPage(1,3);
	//获取点击删除模态框的所在行的id
    $('a[href*="#myModal"]').click(function() {
      $("#contest_span").text($(this).attr("id"));
    });
    //相应删除按钮
    $('#contest_but_del').click(function(){
      var contest_id = $("#contest_span").text();
      //console.log(pro_id);
      //console.log($("#hid_site").val());
      var url = $("#hid_site").val() + '/admin/contest/contest_del';
      $.post(url, {
      	contest_id : contest_id
      },function(e) {
      		if(e == true) {
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
          switch (checked) {
            case '1': var regx = /^[0-9]*$/;
                      if(!regx.test(search)) {
                        alert("请输入正确题号");
                        return; 
                      } else {
                        onSearch(search,0);
                        //thcss();
                        $("#con_bar").remove();
                      }
                      break;
            case '2': onSearch(search,1);
                      $("#con_bar").remove();
                      break;
            case '3': onSearch(search,2);
                      $("#con_bar").remove();
                      break;
            case '4': onSearch(search,3);
                      $("#con_bar").remove();
                      break;       
          }
       }
    });
})

function goPage(pno,psize){

    var itable = document.getElementById("con_table");
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
        x[0].style.width="117px";
        x[1].style.width="550px";
        x[2].style.width="100px";
        x[3].style.width="150px";
        x[4].style.width="100px";
        x[5].style.width="100px";
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
    /*$("#con_table th:eq(0)").width(117);
    $("#con_table th:eq(1)").width(400);
    $("#con_table th:eq(2)").width(200);
    $("#con_table th:eq(3)").width(200);
    $("#con_table th:eq(4)").width(100);
    $("#con_table th:eq(5)").width(100);*/
    thcss();
 
}
//筛表格函数
function onSearch(val,td){
    // setTimeout(function(){
        var storeId = document.getElementById('con_table');
        var rowsLength = storeId.rows.length; 
        var key = val;
  
        var searchCol = td;
  
        for(var i = 0; i < rowsLength; i++){  
            var searchText = storeId.rows[i].cells[searchCol].innerHTML;
  
            if(searchText.match(key) || i == 0){
                storeId.rows[i].style.display='';
            }else{  
                storeId.rows[i].style.display='none'; 
            }  
        }  
    // },200);//200为延时时间  
    //thcss();
} 

function thcss() {
    $("#con_table th:eq(0)").width(117);
    $("#con_table th:eq(1)").width(550);
    $("#con_table th:eq(2)").width(100);
    $("#con_table th:eq(3)").width(150);
    $("#con_table th:eq(4)").width(100);
    $("#con_table th:eq(5)").width(100);
} 