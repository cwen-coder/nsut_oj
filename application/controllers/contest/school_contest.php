<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_contest extends Oj_Controller{
        function __construct(){
		parent::__construct();
		$this->load->model('problem_model','pro');
		$this->load->model('problemsubmit_model','ps');
		$this->load->model('user_model');
	}
        public function enroll(){
            if($this->session->userdata('username') && $this->session->userdata('user_id')){
                                                    $data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
            if($this->user_model->check_new_contest()){
			$data['new_contest'] = $this->user_model->check_new_contest();
			//p($this->user_model->check_new_contest());die;
                }
            if($this->user_model->check_old_contest()){
			$data['old_contest'] = $this->user_model->check_old_contest();
	}
            if(!$data['username'] && !$data['user_id']){
                $this->load->view('contest/school_login.html', $data);
            }else{
                $this->load->view('contest/enroll_page.html', $data);
            }
        }
}