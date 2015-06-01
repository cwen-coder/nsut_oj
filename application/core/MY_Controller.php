<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#前台父控制器
class Index_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->switch_view_on();
	}
}

#OJ前台控制器
class Oj_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->switch_view_off();
		$this->load->model('user_model');

		$this->load->model('privilege_model');
		$res = $this->privilege_model->delete_log(time());

		if($this->session->userdata('user_id')) {
			$user_id = $this->session->userdata('user_id');	
			if($this->privilege_model->get_ip($user_id) != false) {	
				$ip = implode($this->privilege_model->get_ip($user_id));
				if(strcmp($ip,$this->session->userdata('ip')) == 0) {
					$this->load->helper('date');
	        		$format = 'DATE_W3C';
					$time = standard_date($format, time());
					$result = $this->privilege_model->upadte_time($user_id,$time);
				} else {
					$this->session->sess_destroy();
				}
			}else {
				$this->session->sess_destroy();
			}	
		}
	}
}

#后台父控制器
class Admin_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->switch_view_off();
        #权限验证
        if(!$this->session->userdata('username') || $this->session->userdata('privilege') != 1){
            redirect('admin/privilege/index');
       }
	}
}