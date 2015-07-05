$(document).ready(function(){
	$("#user_search_but").click(function() {
		/* Act on the event */
		var username = $("#user_search").val();
		//console.log(username);
		var url = $("#hid_site").val() + '/admin/acmer/user_search';
		$.post(url, {
			username: username
		}, function(data) {
			//alert(data);
			if(data == false) {
				/*var con = $("<h2>用户不存在！</h2>");
				con.appendTo(tbody);*/
				$("#user_table").hide();
				$("#h1_info").text('用户不存在！');
				$("#h1_info").show();
			} else {
				var user = eval("("+data+")");
				$("#tbody").html("");
				$("#h1_info").hide();
				$("#user_table").show();
				var tr = $("<tr></tr>");
          		tr.appendTo(tbody);
          		td = $("<td>"+ user.username +"</td>");
          		td.appendTo(tr);
          		td = $("<td>"+ user.solved +"</td>");
          		td.appendTo(tr);
          		td = $("<td>"+ user.reg_time +"</td>");
          		td.appendTo(tr);
			}
		});
	});
});