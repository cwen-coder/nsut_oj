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
		$contest = $this->oj_con->con_byId($data['contest_id']);
		if(!$this->session->userdata('user_id')){
			$offset = $this->uri->segment(5);
		 	redirect('oj_index/home/contest_list/'.$offset.'/1000');
		 	//echo 1;
		} else if($contest['con_class'] == 2 && (!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $contest['con_pwd'])) {
				$offset = $this->uri->segment(5);
				//echo 2;
				redirect('oj_index/home/contest_list/'.$offset.'/1001/'.$contest_id);
		} else if (time() < strtotime($contest['start_time'])) {
				redirect('contest/home/index/'.$data['contest_id']);
		} else if(time() > strtotime($contest['end_time'])){
			error("对不起比赛已经结束！您无法提交!");
		}else {
			$this->load->view('contest/submit.html',$data);
		}
	}

	//载入状态页
	public function con_status() {
		$data['contest_id'] = $this->uri->segment(4);
		$contest = $this->oj_con->con_byId($data['contest_id']);
		if($contest['con_class'] == 2 && (!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $contest['con_pwd'])) {
				$offset = $this->uri->segment(5);
				//echo 2;
				redirect('oj_index/home/contest_list/'.$offset.'/1001/'.$contest_id);
		}else if (time() < strtotime($contest['start_time'])) {
				redirect('contest/home/index/'.$data['contest_id']);
		}
		$limit=0;
		if($data['pagination'] = $this->input->get('pagination')) 
			$limit = $data['pagination']*20-20;
		if($this->input->get('previous')) 
			$data['previous'] = $this->input->get('previous');
		$num=20;
		$sum = $this->oj_con->con_problem_status_sum($data['contest_id']);
		//p($sum['count(*)']);
		if($data['pagination'] != 0 && $data['pagination']*20 < $sum['count(*)']) {
			$data['pag'] = true;
		}
		$data['pagination'] = $limit/20+2;
		$data['judge_result']=Array("Pending", "Pending Rejudging", "Compiling", "Running & Judging", "Accepted", "Presentation Error", "Wrong Answer", "Time Limit Exceed", "Memory Limit Exceed", "Output Limit Exceed", "Runtime Error", "Compile Error", "Compile OK","Test Running Done");
		$data['judge_color']=Array("btn_status gray","btn_status btn-info","btn_status btn-warning","btn_status btn-warning","btn_status btn-success","btn_status btn-danger","btn_status btn-danger","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-info");
		$data['result'] = $this->oj_con->con_problem_status($data['contest_id'],$limit, $num);
		//p($data);
		$count = count($data['result']);
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		for ($i = 0; $i < $count; $i++) {
			$result = $this->oj_con->get_username($data['result'][$i]['user_id']);
			$data['result'][$i]['username'] = $result['username'];
		}
		$this->load->view('contest/con_status.html',$data);
	}
	//载入编译错误信息或是运行错误信息
	public function false_imformation() {
		$result = $this->input->post('result',TRUE);
		$solution_id = $this->input->post('solution_id',TRUE);
		if($result == 11) {
			$data = $this->oj_con->get_compile_false($solution_id);
			if($data != false) {
				echo $data['error'];
				return;
			} else {
				echo false;
				return;
			}
		} else echo false;
	}

	//获取源码
	public function get_source_code() {
		$solution_id = $this->input->post('solution_id',TRUE);
		$username = $this->input->post('username',TRUE);
		if($username == $this->session->userdata('username')) {
			$data = $this->oj_con->get_source_code($solution_id);
			if($data != false) {
				//echo json_encode($data);
				echo $data['source'];
				return;
			} else {
				echo false;
				return;
			}
		} else echo false;

	}
}