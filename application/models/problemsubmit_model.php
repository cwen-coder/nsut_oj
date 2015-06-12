<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.05.19]
*/
class Problemsubmit_model extends CI_Model{
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}
	function problem_submit($data){
		/*p($data);
		echo Now();*/
		$sql_solution = "insert into solution(problem_id, user_id, in_date, language, ip, code_length, contest_id) values('$data[pid]', '$data[user_id]' , NOW(), '$data[language]', '$data[ip]', '$data[code_length]', '0')";
		$result_solution = mysql_query($sql_solution);
		$insert_id=mysql_insert_id();
		$sql_source = "insert into source_code(solution_id, source) values('$insert_id', '$data[source]')";
		$result_source = mysql_query($sql_source);
		if($result_solution) return true;
		else return false;
	}
	function problem_status($limit, $num){
		$sql = "select solution_id, user_id, memory, time, result, language, code_length, in_date, problem_id from solution where contest_id = '0' order  by solution_id DESC limit $limit, $num";
		$mem = new Memcache(); //创建Memcache对象  
		$mem->connect('127.0.0.1', 11211); //连接Memcache服务器
		if(!($data=$mem->get(md5("mysql_query".$sql)))){
		$result = mysql_query($sql);
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
		$mem->set(md5("mysql_query".$sql), $data, 0, 1);
		}//$mem->delete(md5("mysql_query".$sql),0);
		return $data;
	}
	function compileinfo($solution_id){
		$sql = "select error from compileinfo where solution_id = '$solution_id'";
		$result = mysql_query($sql);
		return mysql_fetch_assoc($result);
	}
	function source($solution_id){
		$sql = "select source from source_code where solution_id = '$solution_id'";
		$result = mysql_query($sql);
		return mysql_fetch_array($result);
	}
	function status_search_pid($limit, $num, $pid){
		$sql = "select solution_id, user_id, memory, time, result, language, code_length, in_date, problem_id from solution where contest_id = '0' and problem_id = '$pid' order  by solution_id DESC limit $limit, $num";
		$result = mysql_query($sql);
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
		//$mem->set(md5("mysql_query".$sql), $data, 0, 1);
		//$mem->delete(md5("mysql_query".$sql),0);
		return $data;
	}
	function status_search_user($limit, $num,$user){
		$sql = "select solution_id, user_id, memory, time, result, language, code_length, in_date, problem_id from solution where contest_id = '0' and user_id = '$user' order  by solution_id DESC limit $limit, $num";
		$result = mysql_query($sql);
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
		//$mem->set(md5("mysql_query".$sql), $data, 0, 1);
		//$mem->delete(md5("mysql_query".$sql),0);
		p($data);die;
		return $data;
	}

}