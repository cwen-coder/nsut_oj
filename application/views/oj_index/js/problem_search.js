
$(document).ready(function(){
  $("#cate").click(function(){
    if($("#cate").val()==3){
      $("#cate_").removeAttr("style");
      $("#cate_th").removeAttr("style");
      $("#search_terms").css("display","none");
    }else{
      $("#cate_").css("display","none");
      $("#cate_th").css("display","none");
      $("#search_terms").removeAttr("style");
    }
  });
  $("#search_but").click(function(){
      var url = $("#hid_site").val()+'/oj_index/home/';
      //console.log(url);
    if($("#cate").val()==1){   
      var href = url + "search?pid=";
      var search_terms = $("#search_terms").val();
      $("#search_but").attr("href", href+encodeURIComponent(search_terms));
    }
    if($("#cate").val()==2){
      var href = url + "search?pn=";
      var search_terms = $("#search_terms").val();
      $("#search_but").attr("href", href+encodeURIComponent(search_terms));
    }
      if($("#cate").val()==3){
      var href = url + "search?pc=";
      var search_terms = $("#cate_cate").val();
      $("#search_but").attr("href", href + search_terms);
    }
  });
  function GetRequest() { 
      var url = location.search; //获取url中"?"符后的字串 
      // console.log(url);
      var theRequest = new Object(); 
      if (url.indexOf("?") != -1) { 
            var str = url.substr(1); 
            strs = str.split("&"); 
            for(var i = 0; i < strs.length; i ++) { 
            theRequest[strs[i].split("=")[0]]=strs[i].split("=")[1]; 
            } 
      }    
      return theRequest; 
} 
  var Request = new Object(); 
  Request = GetRequest();
  var pid = Request['pid'];
  var pn = Request['pn'];
  var pc = Request['pc'];
  //console.log(pn);
  if(pid !=undefined){
    $("#cate").val(1);
    $("#search_terms").val(decodeURIComponent(pid));
  }
  if(pn !=undefined){
    $("#cate").val(2);
    $("#search_terms").val(decodeURIComponent(pn));
  }
  if(pc !=undefined){
    $("#cate").val(3);
    $("#cate").click();
    $("#cate_").val(pc);
  }
});
