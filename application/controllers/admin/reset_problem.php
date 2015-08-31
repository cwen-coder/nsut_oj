<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-7-14)
*/ 
class Reset_problem extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('reset_problem_model','reset_pro');
		$this->load->model('contest_model');
	}

	public function index() {
		$this->load->view('admin/reset_problem.html');
	}
	public function ajax_con_pro() {
		$contest_id = $this->input->post('contest_id',TRUE);
		$sum = $this->contest_model->get_con_pro_sum($contest_id);
		$con_pro_id = $this->contest_model->get_con_pro_id($contest_id);
		//p($sum);
		//p($con_pro_id);
		$data['pro'] = array();
		for($i = 0; $i < $sum['problem_sum']; $i++) {
			$data['pro'][$i] = NULL;
		}
		foreach ($con_pro_id as $v) {
			$data['pro'][$v['num']] = $v;
		}
		$data['contest_id'] = $contest_id;
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$data = json_encode($data);
		echo $data;

	}

	public function con_pro_reset() {
		$contest_id = $this->input->post('contest_id',TRUE);
		$problem_id = $this->input->post('problem_id',TRUE);
		//echo $contest_id.$problem_id;
		$result = $this->reset_pro->con_pro_reset($contest_id,$problem_id);
		if($result == true) {
			success('admin/reset_problem/index','重判成功');
		} else {
			error('重判失败！');
		}
	}
	public function pro_reset() {
		//$contest_id = $this->input->post('contest_id',TRUE);
		$problem_id = $this->input->post('problem_id',TRUE);
		//echo $contest_id.$problem_id;
		$result = $this->reset_pro->pro_reset($problem_id);
		if($result == true) {
			success('admin/reset_problem/index','重判成功');
		} else {
			error('重判失败！');
		}
		
	}
	public function s_pro_reset() {
		$solution_id = $this->input->post('solution_id',TRUE);
		//echo $contest_id.$problem_id;
		$result = $this->reset_pro->s_pro_reset($solution_id);
		if($result == true) {
			success('admin/reset_problem/index','重判成功');
		} else {
			error('重判失败！');
		}
	}
}