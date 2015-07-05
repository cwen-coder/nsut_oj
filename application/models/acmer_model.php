<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Yin_CW <[email address]>
* @copyright [2015.07.05]
*/
class Acmer_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	public function user_search($username) {
		$query = "SELECT user_id, solved, reg_time,username FROM users WHERE username = '$username' ";
		$result = mysql_query($query);
		if($result) {
			$num = mysql_num_rows($result);
			if($num > 0) return mysql_fetch_assoc($result);
			else return false;
		} else return false;
	}

}
?>