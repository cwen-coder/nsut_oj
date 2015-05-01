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
		$query = "select a.problem_id, title, b.class_id from problem a, problem_class b where a.problem_id = b.problem_id";
		$result = mysql_query($query);
	}
}
?>