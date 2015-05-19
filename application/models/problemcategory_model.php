<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.04.29]
*/
class Problemcategory_model extends CI_Model{
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}
	//添加题目类别
	function add($data){
		$query = "insert into class_name(class_name) values('$data')";
		return mysql_query($query);
	}
	//分页展示
	function check($num,$limt){
		$query = "select * from class_name order by class_id limit $limt, $num";
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result))
			$data[] = $row;
		return $data;
	}
	//删除题目类别
	function delete($cid){
		$query = "delete from class_name where class_id = $cid";
		$result = mysql_query($query);
		return $result;
	}
	//查询题目类别总数
	function total_rows(){
		$query = "select* from class_name";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}
	//修改题目类别
	function edit_category($cid, $cate){
		$query = "update class_name set class_name='$cate' where class_id = '$cid' ";
		return mysql_query($query);
	}
}
?>