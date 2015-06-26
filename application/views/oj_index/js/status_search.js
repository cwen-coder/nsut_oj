$(document).ready(function(){
  $("#search_but").click(function(){
    if($('[name="group"]:checked').val()==1){
      var href = "?pid=";
      var search_terms = $("#search_terms").val();
      $("#search_but").attr("href", href+search_terms);
    }
    if($('[name="group"]:checked').val()==2){
      var href = "?user=";
      var search_terms = $("#search_terms").val();
      $("#search_but").attr("href", href+search_terms);
    }
  });
  function GetRequest() { 
      var url = location.search; //获取url中"?"符后的字串 
      var theRequest = new Object(); 
      if (url.indexOf("?") != -1) { 
            var str = url.substr(1); 
            strs = str.split("&"); 
            for(var i = 0; i < strs.length; i ++) { 
            theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
            } 
      }    
      return theRequest; 
} 
  var Request = new Object(); 
  Request = GetRequest();
  var pid = Request['pid'];
  var user = Request['user'];
  if(pid !=undefined){
    $('[name="group"][value="1"]').attr("checked",true);
    $("#search_terms").val(pid);
  }
  if(user !=undefined){
    $('[name="group"][value="2"]').attr("checked",true);
    $("#search_terms").val(user);
  }
});