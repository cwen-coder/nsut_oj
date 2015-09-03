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
			if($num == 1) return mysql_fetch_assoc($result);
			else return false;
		} else return false;
	}

	function volunteer_add($data) {
		$query = "INSERT INTO volunteer(name,pwd,start,end) VALUES('$data[name]','$data[pwd]','$data[start]','$data[end]')";
		$result = mysql_query($query);
		return $result;
	}

	function get_all_volunteer() {
		$query = "SELECT * FROM volunteer WHERE 1 order by id";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}
	function volunteer_del($id) {
		$query = "DELETE FROM volunteer WHERE id = '$id' ";
		$result = mysql_query($query);
		if($result)
			return true;
		else return false;
	}

	function get_volunteer($id) {
		$query = "SELECT * FROM volunteer WHERE id = '$id' ";
		$result = mysql_query($query);
		if($result) {
			$num = mysql_num_rows($result);
			if($num == 1) return mysql_fetch_assoc($result);
			else return false;
		} else return false;
	}

	function volunteer_edit($id,$start,$end) {
		$query = "UPDATE volunteer SET start = '$start', end = '$end' WHERE id = '$id' ";
		$result = mysql_query($query);
		return $result;
	}

	function volunteer_edit_pwd($id,$pwd) {
		$query = "UPDATE volunteer SET pwd = '$pwd' WHERE id = '$id' ";
		$result = mysql_query($query);
		return $result;
	}

	function log_act($data) {
		$query = "SELECT * FROM volunteer WHERE name = '$data[username]'";
		$result = mysql_query($query);
		if($result == true) {
			$num = mysql_num_rows($result);
			if($num == 1) {
				$this->load->library('encrypt');
				$meta = mysql_fetch_assoc($result);
				if ($this->encrypt->decode($meta['pwd']) != $data['password'])return false;
				else return true;		
			} else return false;
		} else {
			return false;
		}
		
	}
}