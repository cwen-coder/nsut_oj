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

	//按题号获取比赛信息
	public function get_contest_id($contest_id) {
		$query = "SELECT * FROM contest where contest_id = '$contest_id' ";
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}

	//修改比赛动作
	public function edit_act($data) {
		$query = "UPDATE contest SET title = '$data[title]', con_class = '$data[con_class]', 
		problem_sum = '$data[problem_sum]', start_time = '$data[start_time]',
		end_time = '$data[end_time]', pre_start_time = '$data[p_s_time]',
		pre_end_time = '$data[p_e_time]',gold = '$data[gold]', 
		silver= '$data[silver]', copper = '$data[copper]', con_pwd = '$data[con_pwd]' 
		WHERE contest_id = '$data[contest_id]' ";
		$result = mysql_query($query);
		return $result;
	}

	//返回比赛题目总数
	public function get_con_pro_sum($contest_id) {
		$query = "SELECT problem_sum FROM contest WHERE contest_id = '$contest_id' ";
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}

	//返回比赛题目id以及num
	public function get_con_pro_id($contest_id) {
		$query = "SELECT problem_id,title,num,source FROM problem_contest 
		WHERE contest_id = '$contest_id'";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//为比赛添加来自题库的题目
	public function add_pro_list($data) {
		$query = "INSERT INTO problem_contest(problem_id,contest_id,title,num,source) VALUES ('$data[problem_id]',
			'$data[contest_id]','$data[title]','$data[num]','$data[source]') ";
		$result = mysql_query($query) or mysql_error();
		return $result;
	}

	//删除比赛题目
	public function del_con_pro($contest_id,$num) {
		$query = "DELETE FROM problem_contest WHERE contest_id = '$contest_id' AND num = '$num' ";
		$result = mysql_query($query);
		return $result;
	}
	//删除新建的比赛题目
	public function new_problem_del($problem_id){
		$query1 = "DELETE FROM problem_contest WHERE problem_id = '$problem_id'";
		$query2 = "DELETE FROM problem WHERE problem_id = '$problem_id'";
		$result1 = mysql_query($query1);
		$result2 = mysql_query($query2);
		if($result1 && $result2) return true;
		else return false;
	}
	//插入题目
	public function add_pro_new($data){
		$sql_pro = "insert into problem(problem_id, title, description, input, output, sample_output, sample_input, spj, hint, in_date, time_limit, memory_limit, defunct, source)
		values('$data[pro_id]', '$data[pro_title]', '$data[content_des]', '$data[content_input]', '$data[content_output]', '$data[sample_output]', '$data[sample_input]',
			'$data[spj]', '$data[hint]', NOW(), '$data[time_limit]', '$data[memory_limit]', 'N', '$data[source]')";
		$result_pro = mysql_query($sql_pro);
		$sql_con_pro = "insert into problem_contest(problem_id, contest_id, title, num, source) values('$data[pro_id]', '$data[contest_id]', '$data[pro_title]', '$data[num]', '0')";
		$result_con_pro = mysql_query($sql_con_pro);
		if($result_pro && $result_con_pro)
			return $data['pro_id'];
		else
			return false;
	}
	//查询题目
	public function check_con_pro($problem_id){
		$sql = "select p.problem_id, c.contest_id, p.title, c.num, p.description, p.input, p.output, p.sample_output, p.sample_input, p.spj, p.hint, p.in_date, p.time_limit, p.memory_limit, p.defunct, p.source 
		from problem p,problem_contest c where p.problem_id = c.problem_id AND p.problem_id='$problem_id'";
		$result = mysql_query($sql);
		return mysql_fetch_assoc($result);
	}
	//修改题目
	public function edit_pro_new($data){
		$sql_pro = "UPDATE problem SET title = '$data[pro_title]',time_limit = '$data[time_limit]',
		memory_limit = '$data[memory_limit]',description = '$data[content_des]',input = '$data[content_input]',
		output =  '$data[content_output]',sample_input = '$data[sample_input]',sample_output = '$data[sample_output]',
		hint = '$data[hint]',source = '$data[source]',spj = '$data[spj]',in_date = NOW(),defunct = 'N'
		WHERE problem_id = '$data[pro_id]'";
		$sql_con_pro = "update problem_contest set title ='$data[pro_title]' where problem_id='$data[pro_id]'";
		if(mysql_query($sql_pro) && mysql_query($sql_con_pro))
			return $data['pro_id'];
		else return false;
	}
}
?>