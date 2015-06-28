<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-6-27)
*/

class Ask_que_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}
	//提问
	public function ask_question($data) {
		$query = "INSERT INTO ask_que(content,ask_user_id,contest_id,time) values('$data[content]','$data[user_id]','$data[contest_id]',NOW()) ";
		$result = mysql_query($query);
		if($result) return true;
		else return false;
	}

	//获取提问
	public function get_all_que($contest_id) {
		$query = "SELECT * FROM ask_que WHERE contest_id = '$contest_id' ORDER BY time desc ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//获取提问总数
	public function get_que_sum($contest_id) {
		$query = "SELECT count(*) FROM ask_que  WHERE contest_id = '$contest_id' ";
		$result = mysql_query($query);
		if($result) {
			$sum = mysql_fetch_assoc($result);
			return $sum['count(*)'];
		} else return false;
	}

}


?>