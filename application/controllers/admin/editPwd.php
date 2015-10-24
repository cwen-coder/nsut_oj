<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen <[email address]>
* @date(2015-10-8)
*/
class EditPwd extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model','user');
	}


    public function index(){
         $this->load->view('admin/reset_password.html');
    }

    public function reset_user() {
    	$username = $this->input->post("username");
    	$newPwd = $this->input->post("user_pwd");
    	$this->load->library('encrypt');
    	if(empty($username) || empty($newPwd)) {
    		error('用户名和密码都不能为空');
    	} else {
    		$clean["username"] = mysql_real_escape_string($username);
    		$clean["newPwd"] = mysql_real_escape_string($this->encrypt->encode($newPwd));
    	}
    	
    	$result = $this->user->reset_user($clean);
    	if($result == true) {
    		success('admin/editPwd/index','修改成功');
    	} else {
    		error('修改失败');
    	}
    }

    public function reset_team() {
    	$team_id = $this->input->post("team_id");
    	$newPwd = $this->input->post("team_pwd");
    	if(empty($team_id) || empty($newPwd)) {
    		error("队伍号和密码都不能为空");
    	} else {
    		$clean["team_id"] = mysql_real_escape_string($team_id);
    		$clean["newPwd"] = mysql_real_escape_string($newPwd);
    	}

    	$result = $this->user->reset_team($clean);
    	if($result == true) {
    		success('admin/editPwd/index','修改成功');
    	} else {
    	    error('修改失败');
    	}
    }
}