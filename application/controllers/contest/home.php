<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Con_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('oj_con_model','oj_con');
	}

	public function index(){
		$contest_id = $this->uri->segment(4);
		/*if(!$this->session->userdata('username')) {
			self::contest_list();
			echo "<script type='text/javascript'>window.onload=function(){document.getElementById('signin').click(); }</script>";
		}*/
		$data['contest'] = $this->oj_con->con_byId($contest_id);
		//p($data['con']);
		if($data['contest']['con_class'] == 2 && (!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $data['contest']['con_pwd'])) {
				$offset = $this->uri->segment(5);
				redirect('oj_index/home/contest_list/'.$offset.'/1001/'.$contest_id);
		}
		
		$this->load->view('contest/contest.html');
	}
	//比赛登录
	public function con_log_act() {
		//self:index();
		$contest_id = $this->input->post('contest_id',TRUE);
		$con_pwd = $this->input->post('con_pwd',TRUE);
		//echo 1;
		$result = $this->oj_con->con_log_act($contest_id,$con_pwd);
		if($result == true) {
			//redirect('contest/home/index/'.$contest_id);
			echo true;
		} else {
			echo false;
		}

	}
}