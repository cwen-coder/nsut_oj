<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* model文件  主要用于对用户权限的控制以及重复登录的控制
* 主要操作loginlog，user 表
* @author Yin_CW <[email address]>
* @copyright [2015.04.27] 
*/

class Privilege_model extends CI_Model {

	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	//获取登录ip
	public function get_ip($user_id) {
		$query = "select ip from loginlog where user_id = '$user_id'";
		$result = mysql_query($query);
		if($result) {
			$ip = $
		}
	}
}