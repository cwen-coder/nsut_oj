<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-7-14)
*/
class Reset_problem_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	public function con_pro_reset($contest_id,$problem_id) {
		/*$sql="UPDATE `solution` SET `result`=1 WHERE `problem_id`=".$rjpid;
		mysql_query($sql) or die(mysql_error());
		$sql="delete from `sim` WHERE `s_id` in (select solution_id from solution where `problem_id`=".$rjpid.")";
		mysql_query($sql) or die(mysql_error());*/
		$query = "UPDATE solution SET result = 1 WHERE contest_id = '$contest_id' AND problem_id = '$problem_id' ";
		$result = mysql_query($query);
		$query1 = "DELETE FROM sim WHERE s_id in (select solution_id from solution where contest_id = '$contest_id' AND problem_id = '$problem_id')";
		$result1 = mysql_query($query1);
		if($result && $result1) {
			return true;
		} else return false;
	}

	public function pro_reset($problem_id) {
		$query = "UPDATE solution SET result = 1 WHERE contest_id = 0 AND problem_id = '$problem_id' ";
		$result = mysql_query($query);
		$query1 = "DELETE FROM sim WHERE s_id in (select solution_id from solution where contest_id = 0 AND problem_id = '$problem_id')";
		$result1 = mysql_query($query1);
		if($result && $result1) {
			return true;
		} else return false;

	}

	public function s_pro_reset($solution_id) {
		$query = "UPDATE solution SET result = 1 WHERE solution_id = '$solution_id' ";
		$result = mysql_query($query);
		$query1 = "DELETE FROM sim WHERE s_id in (select solution_id from solution where solution_id = '$solution_id')";
		$result1 = mysql_query($query1);
		if($result && $result1) {
			return true;
		} else return false;
	}
}
?>