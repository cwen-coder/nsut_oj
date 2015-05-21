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
		$query_solution = "insert into solution(problem_id, user_id, in_date, language, ip, code_length, contest_id) values('$data[pid]', '$data[user_id]' , NOW(), '$data[language]', '$data[ip]', '$data[code_length]', '0')";
		$result_solution = mysql_query($query_solution);
		$insert_id=mysql_insert_id();
		$query_source = "insert into source_code(solution_id, source) values('$insert_id', '$data[source]')";
		$result_source = mysql_query($query_source); 

	}
}