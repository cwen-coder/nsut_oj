<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen <[email address]>
* @date(2015-10-24)
*/

class LoginLog extends Admin_Controller {


	public function index() {
		$this->load->model("user_model","user");
		$result = $this->user->getLoginLog();
		if($result == false) {
			$data['loginLog'] = null;
		} else {
			$data['loginLog'] = $result;
		}
		$this->load->view("admin/loginLog.html",$data);
	}
}