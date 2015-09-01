<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Yin_CW <[email address]>
* @copyright [2015.08.31]
*/

class Volunteer_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	function balloon_add($num,$color) {
		$query1 = " SELECT count(*) FROM balloon WHERE id = '$num' ";
		$result1 = mysql_query($query1);
		if($result1['count(*)'] != 0) {
			return false;
		} else {
			$query2 = "INSERT into balloon(id,color) values('$num','$color') ";
			return mysql_query($query2);
		}
	}

	function get_all_balloon() {
		$query = "SELECT * FROM balloon WHERE 1 order by id";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	function balloon_del($id) {
		$query = "DELETE FROM balloon WHERE id = '$id' ";
		$result = mysql_query($query);
		if($result)
			return true;
		else return false;
	}

	function balloon_edit($id,$color) {
		$query = "UPDATE balloon SET color = '$color' WHERE id = '$id' ";
		$result = mysql_query($query);
		return $result;
	}

	function get_balloon($id) {
		$query = "SELECT * FROM balloon WHERE id = '$id' ";
		$result = mysql_query($query);
		if($result) {
			$num = mysql_num_rows($result);
			if($num > 0) return mysql_fetch_assoc($result);
			else return false;
		} else return false;
	}

	
}