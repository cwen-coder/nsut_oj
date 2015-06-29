<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-6-29)
*/ 
class Ans_que extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('ask_que_model','ask_que');
	}

	public function index () {
		$contest = $this->ask_que->get_now_contest();
		foreach ($contest as $key => $value) {
			$contest[$key]['no_ans_que'] = $this->ask_que->no_ans_que($value['contest_id']);
			$contest[$key]['ans_que_sum'] = $this->ask_que->ans_que_sum($value['contest_id']);
		}
		//p($contest);die;
		$data['contest'] = $contest;
		$this->load->view('admin/ans_que.html',$data);
	}

	//载入回复页
	public function ans_question() {
		$contest_id = $this->uri->segment(4);
		//p($contest_id);
		$no_ans_que = $this->ask_que->no_ans_que($contest_id);
		$ans_que_sum = $this->ask_que->ans_que_sum($contest_id);
		$data['no_ans_que'] = $no_ans_que;
		$data['ans_que_sum'] = $ans_que_sum;
		$this->load->view('admin/ans_que_con.html',$data);
	}
}

?>