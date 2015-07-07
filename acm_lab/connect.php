<?php 
Session_start();
if($_SESSION['privilege'] == 1) {
	$con = mysql_connect("localhost","root","yin123") or die("数据库连接除错！".mysql_error());
	if(mysql_select_db("jol",$con)) {
		echo "连接成功";
	} else {
		echo ('连接失败'.mysql_error());
	}
} else {
	echo "hdhfhdh";
	echo $_SESSION['privilege'];
	var_dump($_SESSION);
}

?>