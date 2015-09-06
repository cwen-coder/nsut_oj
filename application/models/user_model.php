<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author Yin_CW <[email address]>
* @copyright [2015.04.09]
*/
class  User_model extends CI_Model {

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
                //获得已注册队伍数
	public function check_num_team($contest_id) {
		$query = "select * from teams where contest_id = '$contest_id' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}
                   //检查是否已经报名校赛
                   public function check_enroll($user_id, $contest_id){
                                   $query = "select * from teams where contest_id = '$contest_id' and user_id = '$user_id' ";
                                   $result = mysql_query($query);
                                   if(mysql_num_rows($result) > 0 )
                                       return false;
                                   else
                                       return true;
                   }
                   //查询参赛信息
                   public function enroll_info($user_id, $contest_id){
                       $query = "select team_name, contest_id, team_num1, team_name1, team_num2, team_name2, team_num3, team_name3, team_telephone  from teams where contest_id = '$contest_id' and user_id = '$user_id'";
                       $result = mysql_query($query);
                       return mysql_fetch_assoc($result);
                       
                   }
                   //检查邮箱是否重复
	public function check_email($email) {
		$query = "select * from users where email = '$email' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}
                 //检查队名是否存在
	public function teamname_check($teamname, $contest_id, $user_id) {
		$query = "select * from teams where team_name = '$teamname' and contest_id = '$contest_id' and user_id!= '$user_id' ";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}
                //所搜所有参加校赛队伍
                public  function teams(){                                   
                                    $query = "select team_id, team_name, team_name1, team_name2, team_name3, con_class from teams a, contest b where a.contest_id = b.contest_id and (b.con_class = '3' or b.con_class = '4') and b.end_time = (
                                             select  max(b.end_time)  from teams a, contest b where a.contest_id = b.contest_id and (b.con_class = '3' or b.con_class = '4')) order by a.enroll_time";
                                    $result = mysql_query($query);
                                    $data = array();
                                    while($row = mysql_fetch_assoc($result))
                                            $data[] = $row;
                                    return $data;
                }
                //校赛详情显示
                 public  function school_info(){                                   
                                   $query = "select contest_id, title, start_time, end_time, pre_start_time, pre_end_time from contest where (con_class = 4 or con_class= 3) and  end_time=("
                                            . " select  max(end_time) from contest where con_class = 4 or con_class= 3)";
		$result = mysql_query($query);
                                    $data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}//p($data);die;
		return $data;
                }
                //注册写入数据库
	public function enroll($data) {
                                    
		$query = "insert into teams (user_id, contest_id, team_num1, team_name1, team_num2, team_name2, team_num3, team_name3, team_name, enroll_time, team_telephone, team_id) 
		values ('$data[user_id]', '$data[contest_id]', '$data[team_num1]', '$data[team_name1]', '$data[team_num2]' , '$data[team_name2]',  '$data[team_num3]',  '$data[team_name3]',  '$data[team_name]',  '$data[enroll_time]',  '$data[phone]',  '$data[team_id]' )";
		return mysql_query($query);
	}
                //修改参赛信息
                public function updata_enroll($data){
                                    $query = "update teams set team_num1 = '$data[team_num1]', team_name1 = '$data[team_name1]', team_num2 = '$data[team_num2]', team_name2 = '$data[team_name2]', team_num3 = '$data[team_num3]', team_name3 = '$data[team_name3]', team_name = '$data[team_name]', enroll_time = NOW(), team_telephone = '$data[phone]'
                                              where user_id = '$data[user_id]' and contest_id = '$data[contest_id]]' ";
                                    return mysql_query($query);
                }

                public function reg_act($data) {
		$query = "insert into users (user_id, username, password, accesstime, reg_time, ip, email) values ('$data[user_id]', '$data[username]', '$data[password]', '$data[accesstime]', '$data[reg_time]' ,'$data[ip]',  '$data[email] ' )";
		return mysql_query($query);
	}
	//检查是否有校赛新生组
	public function check_new_contest(){
		$query = "select contest_id, title, start_time, end_time, pre_start_time, pre_end_time from contest where con_class ='3' and end_time > NOW()";
		$result = mysql_query($query);
		$data = array();
		$data = mysql_fetch_assoc($result);
		return $data;
	}
	//检查是否有校赛老生组
	public function check_old_contest(){
		$query = "select contest_id, title, start_time, end_time, pre_start_time, pre_end_time from contest where con_class ='4' and end_time > NOW()";
		$result = mysql_query($query);
		$data = array();
		$data = mysql_fetch_assoc($result);
		return $data;
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
			$que1 = "delete  from loginlog where user_id = '$meta[user_id]'";
			$resque1 = mysql_query($que1) or die(mysql_error());
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
                 public function user_password($username){
                                    $query = "select password from users where username = '$username' ";
		$result = mysql_query($query);
		$data = mysql_fetch_assoc($result);
                                   //echo $data;
                                   $this->load->library('encrypt');
		return $this->encrypt->decode($data['password']);
                 }
                  //检查队伍密码
                  public function check_teampassword($data){
                                     $query = "select  a.team_pwd from teams a, users b where a.user_id=b.user_id and a.contest_id = '$data[contest_id]' and b.username = '$data[username]' ";
                                    $result = mysql_query($query);
                                    $meta = mysql_fetch_assoc($result);
                                    if($meta['team_pwd'] == $data['team_password'] )
                                        return $data['contest_id'];
                                    else 
                                        return false;
                  }
                  public function user_rank($limit, $num){
		$sql_query = "select username, submit,solved
				from users
				order by solved desc,submit limit  $limit, $num";
		$result = mysql_query($sql_query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
		return $data;

	}
                 public function user_sum(){
                                   $sql_query = "select count(*) from users order by solved desc,submit";
                                   $result = mysql_query($sql_query);
                                   return mysql_fetch_assoc($result);
                 }

                 public function user_info($user){
		$sql_query = "SELECT a.user_id, a.submit, a.solved, COUNT( b.solved ) rank, a.reg_time
				FROM users a JOIN users b
				WHERE a.solved <= b.solved
				GROUP BY a.username, a.solved
				ORDER BY rank, a.submit";
		$result = mysql_query($sql_query);

	}
	public function school_contest(){
		$sql = "select title, start_time from contest where start_time>NOW() and (con_class='3' or con_class='4') ";
		$result = mysql_query($sql);
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}
		return $data;
	}
}