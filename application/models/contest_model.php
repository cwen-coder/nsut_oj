<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-5-27)
*/
class Contest_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	//获取已添加题目最大题号
	public function get_max_id() {
		$query = "SELECT MAX(contest_id) FROM contest";
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}

	//创建比赛动作
	public function add_act($data) {
		$query = "INSERT INTO contest(contest_id,title,con_class,problem_sum,start_time,end_time,pre_start_time,pre_end_time,gold,silver,copper,con_pwd)
		VALUES ('$data[contest_id]','$data[title]','$data[con_class]','$data[problem_sum]','$data[start_time]','$data[end_time]','$data[p_s_time]',
			'$data[p_s_time]','$data[gold]','$data[silver]','$data[copper]','$data[con_pwd]') ";
		$result = mysql_query($query);
		return $result;
	}

	//获取所有比赛列表
	public function get_all_con() {
		$query = "SELECT contest_id,title,con_class,start_time,end_time FROM contest ORDER BY contest_id DESC";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//删除比赛
	public function contest_del($contest_id) {
		$query = "DELETE FROM contest WHERE contest_id = '$contest_id'";
		$result = mysql_query($query);
		return $result;
	}
}
?>