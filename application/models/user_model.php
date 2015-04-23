<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author Yin_CW <[email address]>
* @copyright [2015.04.09]
*/
class  user_model extends CI_Model {

	//const TBL_CATE = "users";

	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}
	public function check_username($username) {
		$query = "select * from users where username = '$username' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}

	public function check_email($email) {
		$query = "select * from users where email = '$email' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}

	public function reg_act($data) {
		$query = "insert into users (user_id, username, password, accesstime, reg_time, ip, email) values ('$data[user_id]', '$data[username]', '$data[password]', '$data[accesstime]', '$data[reg_time]' ,'$data[ip]',  '$data[email] ' )";
		return mysql_query($query);
	}


	public function log_act ($data) {
		$query = "select user_id,password,privilege from users where username = '$data[username]'";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		//return $num;
		if ($num > 0) {
			$this->load->library('encrypt');
			$meta = mysql_fetch_assoc($result);
			if ($this->encrypt->decode($meta['password']) != $data['password'])
				return false;
			//$user_id = $meta['user_id'];
			$que = "insert into loginlog (user_id,password,ip,time,SAC) values ('$meta[user_id]','$meta[password]','$data[ip]','$data[time]','$data[SAC]') ";
			$res = mysql_query($que);
			if($res) 
				return $meta;
			else 
				return false;
		} else {
			return false;
		}
	}



}