<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-4-29)
*/
class Problem_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}


	public function problem_list($perPage, $offset) {
		$query = "select a.problem_id, a.title, c.class_name, a.accepted, a.submit from problem a, problem_class b,class_name c 
		where a.problem_id = b.problem_id and b.class_id = c.class_id order by problem_id limit $offset,$perPage;";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function problem_all_num() {
		$query = "select a.problem_id, title, c.class_name from problem a, problem_class b,class_name c 
		where a.problem_id = b.problem_id and b.class_id = c.class_id;";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}

	public function problem_del($problem_id) {
		$query1 = "DELETE FROM problem_class WHERE problem_id = '$problem_id'";
		$query2 = "DELETE FROM problem WHERE problem_id = '$problem_id'";
		$result1 = mysql_query($query1);
		$result2 = mysql_query($query2);
		if($result1 && $result2) return true;
		else return false;
	}

	//获取已添加题目最大题号
	public function get_max_id() {
		$query = "select MAX(pc.problem_id) from problem p,problem_class pc where p.problem_id=pc.problem_id";
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}

	//ajax检查题号
	public function check_id($problem_id) {
		$query = "SELECT * FROM problem WHERE problem_id = '$problem_id'";
		$result = mysql_query($query);
		return mysql_num_rows($result);
	}

	//获取已有分类
	public function get_class() {
		$query = "SELECT class_id,class_name FROM class_name WHERE 1";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	//按题号获取题
	public function get_problem_id($problem_id) {
		$query = "SELECT * FROM problem a, problem_class b,class_name c 
		WHERE a.problem_id = '$problem_id' AND a.problem_id = b.problem_id AND b.class_id = c.class_id  ";
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}

	//题目添加动作
	public function add_act($data) {
		$query_p = "INSERT into problem(problem_id,title,time_limit,memory_limit,
		description,input,output,sample_input,sample_output,hint,source,spj,in_date,defunct) 
		VALUES ('$data[problem_id]','$data[title]','$data[time_limit]','$data[memory_limit]',
		'$data[description]','$data[input]','$data[output]','$data[sample_input]',
		'$data[sample_output]','$data[hint]','$data[source]','$data[spj]',NOW(),'N')";
		$query_c = "INSERT into problem_class(problem_id,class_id) VALUES ('$data[problem_id]','$data[class_id]')";
		$result_p = mysql_query($query_p);
		$result_c = mysql_query($query_c);
		if($result_p && $result_c) return true;
		else return false;
	}

	//返回数据库配置常量
	public function get_oj_data() {
		$OJ_DATA = "/home/judge/data";
		return $OJ_DATA ;
	}

	//存放用户编辑题目权限
	public function privilege($user_id,$problem_id) {
		$query = "INSERT into privilege (user_id,rightstr)  
		VALUES('$user_id','$problem_id')";
		$reslut = mysql_query($query);
		return $reslut;
	}

	//题目修改动作
	public function edit_act($data) {
		$query_p = "UPDATE problem SET title = '$data[title]',time_limit = '$data[time_limit]',
		memory_limit = '$data[memory_limit]',description = '$data[description]',input = '$data[input]',
		output =  '$data[output]',sample_input = '$data[sample_input]',sample_output = '$data[sample_output]',
		hint = '$data[hint]',source = '$data[source]',spj = '$data[spj]',in_date = NOW(),defunct = 'N'
		WHERE problem_id = '$data[problem_id]'";
		$query_c = "UPDATE problem_class SET class_id = '$data[class_id]' WHERE problem_id = '$data[problem_id]'";
		$result_p = mysql_query($query_p);
		$result_c = mysql_query($query_c);
		if($result_p && $result_c) return true;
		else return false;
	}
	//按题号搜索题目
	public function search_problem_byId($problem_id) {
		$query = "SELECT a.problem_id,a.title,c.class_name FROM problem a, problem_class b,class_name c 
		WHERE a.problem_id = '$problem_id' AND a.problem_id = b.problem_id AND b.class_id = c.class_id  ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if($num < 1) return 0;
		else return mysql_fetch_assoc($result);
	}

	//按标题搜索题目
	public function search_problem_byTitle($title) {
		$query = "SELECT a.problem_id,a.title,c.class_name FROM problem a, problem_class b,class_name c 
		WHERE title = '$title' AND a.problem_id = b.problem_id AND b.class_id = c.class_id  ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if($num < 1) return 0;
		else return mysql_fetch_assoc($result);
	}

	//按题目分类查询题目
	public function search_problem_byClass($calss_name) {
		$query = "SELECT a.problem_id,a.title,c.class_name FROM problem a, problem_class b,class_name c 
		WHERE c.class_name = '$calss_name' AND a.problem_id = b.problem_id AND b.class_id = c.class_id  ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if($num < 1) return 0;
		else {
			$problem = array();
			while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
				$problem[] = $row;
			}
			return $problem;
		}
	}
	//检查某一题是否以ＡＣ
	public function problem_check($user_id, $pid){
		$query = "select* from solution where user_id = '$user_id' and result = '4' and problem_id='$pid'";
		$result = mysql_query($query);
		if(mysql_num_rows($result)==0) return false;
			else return true;
	}

}
?>