<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-6-05)
*/
class Rank_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	public function get_user_byContest($contest_id) {
		$query = "SELECT user_id FROM solution WHERE contest_id = '$contest_id' group by user_id ";
		$result = mysql_query($query); 
		if($result) {
			$data = array();
			while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		} else return false;
	}

	public function get_con_byContest($contest_id) {
		$query = "SELECT problem_id,num FROM problem_contest WHERE contest_id = '$contest_id' ";
		$result = mysql_query($query); 
		if($result) {
			$data = array();
			while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		} else return false;
	}

	public function get_con_pro_info($contest_id,$user_id,$num) {
		$query_s = "SELECT count(*) FROM solution WHERE user_id = '$user_id' AND contest_id = '$contest_id' AND num = '$num' AND result != 4 ";
		$result = mysql_query($query_s); 
		if($result) {
			return mysql_fetch_assoc($result);
		} else return false;
	}
	public function get_con_pro_ac($contest_id,$user_id,$num) {
		$query = "SELECT in_date FROM solution WHERE user_id = '$user_id' AND contest_id = '$contest_id' AND num = '$num' AND result = 4 order by in_date ";
		$result = mysql_query($query); 
		if($result) {
			return mysql_fetch_assoc($result);
		} else return false;
	}

	public function error_after_ac($contest_id,$user_id,$num,$in_date) {
		$query_s = "SELECT count(*) FROM solution WHERE user_id = '$user_id' AND contest_id = '$contest_id' AND num = '$num' AND result != 4 AND in_date > '$in_date'";
		$result = mysql_query($query_s); 
		if($result) {
			return mysql_fetch_assoc($result);
		} else return false;
	}
}

?>