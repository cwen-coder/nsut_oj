$(document).ready(function() {
	  $("table tr").each(function () {
        //$(this).find("td").eq(0).css('background-color','red');
        var len = $(this).find("td").length;
        //console.log(len);
	        if(len > 0) {
	        	for (var i = 3; i < len; i++ ) {
	        		//Things[i]
	        		var val = $(this).find("td").eq(i).text();
	        		var error = $(this).find("td").eq(i).attr('name');
	        		//console.log(val.length);
	        		var len_val = val.length;
	        		if(len_val > 0 && len_val <= 5) {
	        			$(this).find("td").eq(i).css('background-color','#FFDFBF');
	        		} else if(len_val > 6 && error != 0) {
	        			$(this).find("td").eq(i).css('background-color','#E1FFB5');
	        		} else if(len_val > 6 && error == 0) {
	        			$(this).find("td").eq(i).css('background-color','#008800');
	        		}
	        	}
	        }
      });
	
});