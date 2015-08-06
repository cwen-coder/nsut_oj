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

#网站前台控制器
class Con_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->switch_view_off();
        #权限验证
        if(!$this->session->userdata('username')) {
		 	$offset = $this->uri->segment(5);
		 	redirect('oj_index/home/contest_list/'.$offset.'/1000');
			//echo "<script type='text/javascript'>window.onload=function(){document.getElementById('signin').click(); }</script>";
		}
	}
}

class Sch_Controller extends CI_Controller{
    public function __construct() {
        parent::__construct();
                $this->load->switch_view_off();
                $this->load->model('user_model');
            if(($a=$this->session->userdata('school_contest')) && ($b=$this->session->userdata('username')) && ($c=$this->session->userdata('user_id')) ){
                                                    $data['contest_id'] =$a;
                                                    $data['username'] =  $b;                                                   
			$data['user_id'] = $c;
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
         if(!isset($data['contest_id'] )){
         if($this->session->userdata('school_contest')){
                                        $data['school_contest'] = $this->session->userdata('school_contest');
                                    }
		 if($a=$this->user_model->check_new_contest()){
			$data['new_contest'] = $a;
			//p($this->user_model->check_new_contest());die;
                                    }
                                    if($b=$this->user_model->check_old_contest()){
			$data['old_contest'] = $b;
                                    }
                                    $data['check_enroll_old'] = true;
                                    $data['check_enroll_new'] = true;
                                   if($data['user_id'] && (isset($data['new_contest']) ||isset($data['old_contest'])) ){
                                                    $data['check_enroll_old'] = $this->user_model->check_enroll($data['user_id'], isset($data['old_contest']['contest_id'])? $data['old_contest']['contest_id'] : '-1');
                                                    $data['check_enroll_new'] = $this->user_model->check_enroll($data['user_id'], isset($data['new_contest']['contest_id'])? $data['new_contest']['contest_id'] : '-1');
                                   }
                                   if($c=$this->user_model->school_info()){
                                                    $data['school_info'] = $c;
                                   }
                $this->load->view('contest/school_contest.html',$data);
             }
    }
}