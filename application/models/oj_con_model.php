<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-6-1)
*/
class Oj_con_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	//获取正在进行或是还未开始的比赛
	public function get_now_contest() {
		$query = "SELECT contest_id,title,con_class,start_time,end_time FROM contest WHERE end_time > NOW() and  (con_class = 1 or con_class = 2) ORDER BY contest_id DESC";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function con_pass_list($perPage, $offset) {
		$query = "SELECT contest_id,title,con_class,start_time,end_time FROM contest WHERE end_time < NOW() and (con_class = 1 or con_class = 2) ORDER BY contest_id DESC limit $offset,$perPage ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//获取已结束比赛的总数
	public function pass_con_num() {
		$query = "SELECT count(*) FROM contest WHERE end_time < NOW() and (con_class = 1 or con_class = 2)";
		$result = mysql_query($query);
		return  mysql_fetch_assoc($result);
	}

	//根据比赛id获取比赛信息
	public function con_byId($contest_id) {
		$query = "SELECT contest_id,title,con_class,start_time,end_time,con_pwd,problem_sum FROM contest WHERE contest_id = '$contest_id' ";
		$result = mysql_query($query);
		return  mysql_fetch_assoc($result);
	}
	//比赛登录
	public function con_log_act($contest_id,$con_pwd) {
		$query = "SELECT con_class,con_pwd FROM contest WHERE contest_id = '$contest_id'";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if($num > 0) {
			//return 1;
			$this->load->library('encrypt');
			$meta = mysql_fetch_assoc($result);
			if($this->encrypt->decode($meta['con_pwd']) != $con_pwd) {
				return false;
			} else {
				$this->session->set_userdata('con_pwd',$meta['con_pwd']);
				return true;
			}
		}else return false;
	}

	//获取某场比赛用户提交过的题目
	public function get_con_pro_sub($user_id,$contest_id) {
		$query = "SELECT problem_id FROM solution WHERE user_id = '$user_id' AND contest_id = '$contest_id' GROUP BY problem_id ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//获取某场比赛用户AC的题目
	public function get_con_pro_ac($user_id,$contest_id) {
		$query = "SELECT problem_id FROM solution WHERE user_id = '$user_id' AND contest_id = '$contest_id' AND result = 4 GROUP BY problem_id ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//获取某场比赛题目详情
	public function con_pro_byId($problem_id) {
		$query = "SELECT problem_id,title,description,input,output,sample_input,sample_output,hint,source,time_limit,memory_limit FROM problem WHERE problem_id = '$problem_id' ";
		$result = mysql_query($query);
		if($result) {
			return  mysql_fetch_assoc($result);
		} else return false;

	}
}
?>