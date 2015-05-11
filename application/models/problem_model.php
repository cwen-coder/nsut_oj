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
		$query = "select a.problem_id, title, c.class_name from problem a, problem_class b,class_name c where a.problem_id = b.problem_id and b.class_id = c.class_id order by problem_id limit $offset,$perPage;";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function problem_all_num() {
		$query = "select a.problem_id, title, c.class_name from problem a, problem_class b,class_name c where a.problem_id = b.problem_id and b.class_id = c.class_id;";
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
		$query = "SELECT MAX(problem_id) FROM problem";
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
	public function get_problem($Problem_id) {
		$query = "SELECT * FROM problem a, problem_class b,class_name c WHERE a.problem_id = '$problem_id' AND a.problem_id = b.problem_id AND b.class_id = c.class_id  ";
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}
}
?>