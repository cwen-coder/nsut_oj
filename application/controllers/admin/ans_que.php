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
		$no_ans_question = $this->ask_que->get_all_no_ans_question($contest_id);
		$ans_question = $this->ask_que->get_all_ans_question($contest_id);
		$this->load->model('oj_con_model','oj_con');
		$sum = count($no_ans_question);
		for ($i = 0; $i < $sum; $i++) {
			$result = $this->oj_con->get_username($no_ans_question[$i]['ask_user_id']);
			$no_ans_question[$i]['username'] = $result['username'];
		}

		$sum1 = count($ans_question);
		for ($i = 0; $i < $sum1; $i++) {
			$result = $this->oj_con->get_username($ans_question[$i]['ask_user_id']);
			$answer = $this->ask_que->get_answer($ans_question[$i]['id']);
			$ans_question[$i]['answer'] = $answer;
			$ans_question[$i]['username'] = $result['username'];
		}

		$data['no_ans_que'] = $no_ans_que;
		$data['ans_que_sum'] = $ans_que_sum;
		$data['no_ans_question'] = $no_ans_question;
		$data['ans_question'] = $ans_question;
		//p($data);die;
		$this->load->view('admin/ans_que_con.html',$data);
	}

	//删除提问
	public function del_ask_que() {
		$id = $this->input->post('ask_id',TRUE);
		$result = $this->ask_que->del_ask_que($id);
		if($result) echo true;
		else echo false;
	}

	//回复提问
	public function admin_ans_que() {
		$que_id = $this->input->post('que_id',TRUE);
		$content = $this->input->post('content',TRUE);
		$user_id = $this->session->userdata('user_id');	
		$data = array(
			'que_id' => $que_id,
			'content' => $content,
			'user_id' => $user_id
			);
		$result = $this->ask_que->admin_ans_que($data);
		if($result) echo true;
		else echo false;
	}

	//删除回复
	public function del_ask_ans() {
		$id = $this->input->post('id',TRUE);
		$que_id = $this->input->post('que_id',TRUE);
		//$que_id = $this
		$result = $this->ask_que->del_ask_ans($id,$que_id);
		if($result) echo true;
		else echo false;
	}
}

?>