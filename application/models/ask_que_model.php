<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-6-27)
*/

class Ask_que_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	public function get_all_que($contest_id) {
		$query = "SELECT * FROM ask_que WHERE contest_id = '$contest_id' ";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

}


?>