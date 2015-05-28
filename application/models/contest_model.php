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

}
?>