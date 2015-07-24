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
	public function get_all_que($contest_id,$perPage,$offset) {
		$query = "SELECT * FROM ask_que WHERE contest_id = '$contest_id' ORDER BY time desc limit $offset,$perPage";
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

	//获取正在进行中的比赛
	public function get_now_contest() {
		$query = "SELECT contest_id,title,con_class,start_time,end_time FROM contest WHERE end_time > NOW() and start_time < NOW() ORDER BY start_time DESC";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//获取未回复提问数目
	public function no_ans_que($contest_id) {
		$query = "SELECT count(*) FROM ask_que WHERE contest_id = '$contest_id' AND ans_num <= 0 ";
		$result = mysql_query($query);
		if($result) {
			$sum = mysql_fetch_assoc($result);
			return $sum['count(*)'];
		} else return false;
	}

	//获取回复提问数目
	public function ans_que_sum($contest_id) {
		$query = "SELECT count(*) FROM ask_que WHERE contest_id = '$contest_id' AND ans_num > 0 ";
		$result = mysql_query($query);
		if($result) {
			$sum = mysql_fetch_assoc($result);
			return $sum['count(*)'];
		} else return false;
	}


	//获取已回复提问
	public function get_all_no_ans_question($contest_id) {
		$query = "SELECT * FROM ask_que WHERE contest_id = '$contest_id' AND ans_num <= 0 order by time desc ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//获取未回复提问
	public function get_all_ans_question($contest_id) {
		$query = "SELECT * FROM ask_que WHERE contest_id = '$contest_id' AND ans_num > 0 order by time desc ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//删除提问
	public function del_ask_que($id) {
		$query = "DELETE FROM ask_que WHERE id = '$id' ";
		$result = mysql_query($query);
		if($result) return true;
		else return false;
	}


	//回复提问
	public function admin_ans_que($data) {
		$query = "INSERT INTO ask_ans(content,que_id,user_id,time) values('$data[content]','$data[que_id]','$data[user_id]',NOW()) ";
		$query1 = "UPDATE ask_que SET ans_num = ans_num + 1 WHERE id = '$data[que_id]' ";
		$result = mysql_query($query);
		$result1 = mysql_query($query1);
		if($result && $result1) return true;
		else return false;
	}

	//获取回复
	public function get_answer($que_id) {
		$query = "SELECT * FROM ask_ans WHERE que_id = '$que_id'  ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}
	//删除提问
	public function del_ask_ans($id,$que_id) {
		$query = "DELETE FROM ask_ans WHERE id = '$id' ";
		$query1 = "UPDATE ask_que SET ans_num = ans_num - 1 WHERE id = '$que_id' ";
		$result = mysql_query($query);
		$result1 = mysql_query($query1);
		if($result && $result1) return true;
		else return false;
	}
}


?>