<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-5-26)
*/
class Contest extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('contest_model');
	}

	public function index() {
		$data['contest'] = $this->contest_model->get_all_con();
		//$data['contest'] = json_encode($data['contest']);
		$data['now'] = date('Y-m-d h:i:s',time());
		//p($data);
		
		$this->load->view('admin/contest.html',$data);
	}

	//载入创建比赛页面
	public function contest_add() {
		$data['con_id'] = $this->contest_model->get_max_id();
		//p($data['con_id']['MAX(contest_id)']);
		if ($data['con_id']['MAX(contest_id)'] == false) {
			$data['con_id']['MAX(contest_id)'] = 1000;
		} else {
			$data['con_id']['MAX(contest_id)'] += 1;
		}
		$this->load->view("admin/contest_add.html",$data);
	}


	//创建比赛动作
	public function con_add_act() {
		$this->load->library('encrypt');
		$data = array(
				'contest_id' => $this->input->post('con_id',TRUE),
				'title' => $this->input->post('con_title',TRUE),
				'con_class' => $this->input->post('con_class',TRUE),
				'problem_sum' => $this->input->post('con_num',TRUE),
				'start_time' => $this->input->post('start_time',TRUE),
				'end_time' => $this->input->post('end_time',TRUE),
				'p_s_time' => $this->input->post('p_s_time',TRUE),
				'p_e_time' => $this->input->post('p_e_time',TRUE),
				'gold' => $this->input->post('gold',TRUE),
				'silver' => $this->input->post('silver',TRUE),
				'copper' => $this->input->post('copper',TRUE),
				'con_pwd' => $this->encrypt->encode($this->input->post('con_pwd',TRUE))
			);
		//p($data);
		$result = $this->contest_model->add_act($data);
		if($result) {
			success('admin/contest/index','创建成功');
		} else error("创建失败");
	}
	//删除比赛
	public function contest_del() {
		$problem_id = $this->input->post('contest_id',TRUE);
		$result = $this->contest_model->contest_del($problem_id);
		if($result) echo true;
		else echo false;
	}

}
?>