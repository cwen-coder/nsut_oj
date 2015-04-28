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
			$ip = mysql_fetch_assoc($result);
			return $ip;
		} else {return false;}
	}


	//获取最后操作时间
	/*public function get_time($user_id) {
		$query = "select time from loginlog where user_id = '$user_id'";
		$result = mysql_query($query);
		if($result) {
			$time = mysql_fetch_assoc($result);
			return $time;
		} else {return false;}
	}*/

	//更新最后登录时间
	public function upadte_time($user_id,$time) {
		$query = "update loginlog set time = '$time' where user_id = '$user_id'";
		$result = mysql_query($query);
		if($result) 
			return true;
		else 
			return false;
	}

	//清除过期登录日志
	public function delete_log($now) {
		$query = "delete from loginlog where (UNIX_TIMESTAMP(time)-'$now')%86400/60 > 60";
		$result = mysql_query($query);
		return $result;
	}
}