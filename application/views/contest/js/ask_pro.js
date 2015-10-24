function check() {
	var content = $("#content").val();
	if(content.length == 0) {
		alert("提问内容不能为空！");
		return false;
	}
	return true;
}