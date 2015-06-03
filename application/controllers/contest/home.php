<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Con_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('oj_con_model','oj_con');
		$this->load->model('contest_model');
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
		$user_id = $this->session->userdata('user_id');
		$con_pro_id = $this->contest_model->get_con_pro_id($contest_id);
		$con_pro_sub = $this->oj_con->get_con_pro_sub($user_id,$contest_id);
		$con_pro_ac = $this->oj_con->get_con_pro_ac($user_id,$contest_id);
		$data['pro'] = array();
		foreach ($con_pro_id as $v) {
			$data['pro'][$v['num']] = $v;
			foreach ($con_pro_sub as $sub) {
				if($v['problem_id'] == $sub['problem_id']) {
					$temp = 0;
					foreach ($con_pro_ac as $ac) {
						if($v['problem_id'] == $ac['problem_id']) {
							$data['pro'][$v['num']]['status'] = true;
							$temp = 1;
							break;
						} /*else {
							$data['pro'][$v['num']]['status'] = 0;
							break;
						}*/
					}
					if($temp == 0) {
						$data['pro'][$v['num']]['status'] = false;
					}
				}
			}
		}
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$this->load->view('contest/contest.html',$data);
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
			return;
		} else {
			echo false;
			return;
		}

	}
	//载入比赛题目
	public function con_pro() {
		$contest_id = $this->uri->segment(4);
		$problem_id = $this->uri->segment(5);
		$num = $this->uri->segment(6);
		$data['pro'] = $this->oj_con->con_pro_byId($problem_id);
		$data['num'] = $num;
		$data['contest_id'] = $contest_id;
		//echo "jdfkdjfkdfjkj";
		//p($data);
		$this->load->view('contest/con_pro.html',$data);
	}

	//载入提交页
	public function con_pro_sub() {
		$data['contest_id'] = $this->uri->segment(4);
		$data['problem_id'] = $this->uri->segment(5);
		$data['num'] = $this->uri->segment(6);
		$this->load->view('contest/submit.html',$data);
	}
}