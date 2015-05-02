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


	public function problem_list() {
		$query = "select a.problem_id, title, c.class_name from problem a, problem_class b,class_name c where a.problem_id = b.problem_id and b.class_id = c.class_id order by problem_id;";
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
}
?>