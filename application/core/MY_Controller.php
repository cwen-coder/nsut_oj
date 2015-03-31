<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#前台父控制器
class Index_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->switch_view_on();
	}
}


#后台父控制器
class Admin_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->switch_view_off();
        #权限验证
        if(!$this->session->userdata('username') ){
            redirect('admin/privilege/login');
       }
	}
}