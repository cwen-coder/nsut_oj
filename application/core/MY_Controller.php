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