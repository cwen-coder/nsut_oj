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
	//
	function add($data){
		$query = "insert into class_name(class_name) values('$data')";
		return mysql_query($query);
	}
	function check($num,$limt){
		$query = "select * from class_name limit $limt, $num";
		$result = mysql_query($query);
		while($row = mysql_fetch_assoc($result))
			$data[] = $row;
		return $data;
	}
	function delete($cid){
		$query = "delete from class_name where class_id = $cid";
		$result = mysql_query($query);
		return $result;
	}
	function total_rows(){
		$query = "select* from class_name";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}
	function edit_category($cid, $cate){
		$query = "update class_name set class_name='$cate' where class_id = '$cid' ";
		return mysql_query($query);
	}
}
?>