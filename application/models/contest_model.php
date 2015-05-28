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
		$sql = "INSERT INTO contest(contest_id,title,con_class,problem_sum,start_time,end_time,pre_start_time,pre_end_time,gold,silver,copper,con_pwd)
		VALUES ('$data[contest_id]','$data[title]','$data[con_class]','$data[problem_sum]','$data[start_time]','$data[end_time]','$data[p_s_time]',
			'$data[p_s_time]','$data[gold]','$data[silver]','$data[copper]','$data[con_pwd]') ";
		$result = mysql_query($sql);
		return $result;
	}
}
?>