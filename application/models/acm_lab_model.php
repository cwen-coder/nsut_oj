<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Yin_CW <[email address]>
* @copyright [2015.07.07]
*/
class Acm_lab_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	public function all_acmer_info() {
		$query = "SELECT * FROM acmer where 1 order by sum10 desc";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function update_solved($data,$id) {
		$query = "UPDATE acmer SET hdoj_solved = '$data[hdoj_solved]',poj_solved = '$data[poj_solved]',cf_rating = '$data[cf_rating]' ,sutoj_solved = '$data[sutoj_solved]' where id = '$id' ";
		$result = mysql_query($query);
		if($result) {
			$query1 = " SELECT last_time FROM acmer WHERE id = '$id' ";
			$result1 = mysql_query($query1);
			if($result1)
				return mysql_fetch_assoc($result1);
			else return false;
		}else return false;
	}

	public function get_sutoj_solved($username) {
		$query = " SELECT solved FROM users WHERE username = '$username' ";
		$result = mysql_query($query);
		if($result) {
			$data = mysql_fetch_assoc($result1);
			return $data['solved'];
		} else return 0;
	}

	public function update_one_solved($cha_all,$id) {
		$query = " UPDATE acmer SET sum10 = sum10 + '$cha_all' WHERE id = '$id' ";
		$query1 = " UPDATE sum_solved SET day0 = day0 + '$cha_all' WHERE id = '$id' ";
		$result = mysql_query($query);
		$result1 = mysql_query($query1);
		if($result && $query1) return true;
		else return false;
	}
}
?>