<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author Yin_CW <[email address]>
* @copyright [2015.04.09]
*/
class  user_model extends CI_Model{

	//const TBL_CATE = "users";

	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}
	public function check_username($username){
		$query = "select * from users where username = '$username' ";
		$result = mysql_query($query);
		$data = mysql_num_rows($result);
		echo $data;
	}
}