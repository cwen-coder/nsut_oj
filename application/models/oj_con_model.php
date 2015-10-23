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
		$query = "SELECT contest_id,title,con_class,start_time,end_time FROM contest WHERE end_time > NOW() and  (con_class = 1 or con_class = 2) ORDER BY start_time DESC";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function con_pass_list($perPage, $offset) {
		$query = "SELECT contest_id,title,con_class,start_time,end_time FROM contest WHERE end_time < NOW() and (con_class = 1 or con_class = 2) ORDER BY end_time DESC limit $offset,$perPage ";
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
		$query = "SELECT contest_id,title,con_class,start_time,end_time,con_pwd,problem_sum, gold, silver, copper FROM contest WHERE contest_id = '$contest_id' ";
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

	//判断题目是否存在
	public function check_pro($problem_id) {
		$query = "SELECT problem_id FROM problem WHERE problem_id = '$problem_id' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if($num > 0) return true;
		else return false;
	}
	//判断比赛是否存在
	public function check_con($contest_id) {
		$query = "SELECT contest_id FROM contest WHERE contest_id = '$contest_id' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if($num > 0) return true;
		else return false;
	}
	//判断比赛中是否存在某题
	public function check_con_pro($problem_id,$contest_id) {
		$query = "SELECT num FROM problem_contest WHERE contest_id = '$contest_id' and  problem_id = '$problem_id' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if($num > 0) return mysql_fetch_assoc($result);
		else return false;
	}
                 //检测用户是否报名
                function check_user_con($user_id, $contest_id){
                                $query = "SELECT * FROM teams WHERE contest_id = '$contest_id' and  user_id = '$user_id' ";
                                $result = mysql_query($query);
                                if(empty($result))
                                    return false;
                                else
                                      return true;               
                }
                  //提交题目动作
	function problem_submit($data){
		/*p($data);
		echo Now();*/
		$sql_solution = "insert into solution(problem_id, user_id, in_date, language, ip, code_length, contest_id,num) values('$data[pid]', '$data[user_id]' , NOW(), '$data[language]', '$data[ip]', '$data[code_length]', '$data[cid]', '$data[num]')";
		$result_solution = mysql_query($sql_solution);
		if($result_solution) {
			$insert_id=mysql_insert_id();
			$sql_source = "insert into source_code(solution_id, source) values('$insert_id', '$data[source]')";
			$result_source = mysql_query($sql_source);
			if($result_source){
                                                                return true;
                                                    }
			else{
                                                        return false;
                                                    }
		} else{
                                            return false;
                                    }
	}

	//比赛题目状态页
	public function con_problem_status($contest_id,$limit,$num) {
		$query = "select solution_id, problem_id,user_id, memory, time, result, language, code_length, in_date, num from solution where contest_id = '$contest_id' order  by solution_id DESC limit $limit,$num ";
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
		return $data;
	}
	//比赛题目状态总数
	public function con_problem_status_sum($contest_id) {
		$query = "select count(*) from solution where contest_id = '$contest_id'";
		$result = mysql_query($query);
		if ($result) {
				return mysql_fetch_assoc($result);
		} else return false;
	}

	//获取username
	public function get_username($user_id) {
		$query = "SELECT username FROM users WHERE user_id = '$user_id' ";
		$result = mysql_query($query);
		if ($result) {
			$num = mysql_num_rows($result);
			if($num > 0) {
				return mysql_fetch_assoc($result);
			} else return false;
		} else return false;
	}
                //获取队伍名
                    public function get_teamname($user_id, $contest_id) {
		$query = "SELECT team_name,team_id FROM teams WHERE user_id = '$user_id' and contest_id = '$contest_id' ";
		$result = mysql_query($query);
		if ($result) {
			$num = mysql_num_rows($result);
			if($num > 0) {
				return mysql_fetch_assoc($result);
			} else return false;
		} else return false;
	}
	//获取编译错误信息
	public function get_compile_false($solution_id) {
		$query = "SELECT error FROM compileinfo WHERE solution_id = '$solution_id' ";
		$result = mysql_query($query);
		//$num = mysql_num_rows($result);
		if ($result) {
			$num = mysql_num_rows($result);
			if($num > 0) {
				return mysql_fetch_assoc($result);
			} else return false;
		} else return false;
	}
	//获取源码
	public function get_source_code($solution_id) {
		$query = "SELECT source FROM source_code WHERE solution_id = '$solution_id' ";
		$result = mysql_query($query);
		//$num = mysql_num_rows($result);
		if ($result) {
			$num = mysql_num_rows($result);
			if($num > 0) {
				return mysql_fetch_assoc($result);
			} else return false;
		} else return false;
	}
                  //获取题号
	public function get_pro_num($solution_id) {
		$query = "SELECT num, contest_id,problem_id, language FROM solution WHERE solution_id = '$solution_id' ";
		$result = mysql_query($query);
		//$num = mysql_num_rows($result);
		if ($result) {
			$num = mysql_num_rows($result);
			if($num > 0) {
				return mysql_fetch_assoc($result);
			} else return false;
		} else return false;
	}

	public function get_con_class($id) {
		$query = "SELECT con_class FROM contest WHERE contest_id = '$id' ";
		$result = mysql_query($query);
		//$num = mysql_num_rows($result);
		if ($result) {
			$num = mysql_num_rows($result);
			if($num > 0) {
				return mysql_fetch_assoc($result)["con_class"];
			} else return false;
		} else return false;
	}
}
?>