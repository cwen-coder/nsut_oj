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
		$sql_source = "insert into source_code(solution_id, source) values('$insert_id', '$data[source]')";
		/*if($OJ_MEMCACHE){
				$this->load->library('CI_Memcache');
				$mem = new CI_Memcache();
				$mem->mc = $mem->init();
				$mem->mc->delete(mad("mysql_query".$),0);
			}
		else{
		$result_solution = mysql_query($sql_solution);
		$insert_id=mysql_insert_id();
		$result_source = mysql_query($sql_source); 
		}*/
	}
	function problem_status($limit, $num){
		$sql = "select solution_id, user_id, memory, time, result, language, code_length, in_date, problem_id from solution order  by solution_id DESC limit $limit, $num";
		$result = mysql_query($sql);
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
		return $data;
	}
}