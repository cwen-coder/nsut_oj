<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.06.10]
*/
class Ask_pro extends Con_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('ask_que_model','ask_pro');
	}

	//载入比赛提问页面
	public function index() {
		$data['contest_id'] = $this->uri->segment(4);
		$ask_pro = $this->ask_pro->get_all_que($data['contest_id']);
		//p($ask_pro);die;
		$data['question_sum'] = $this->ask_pro->get_que_sum($data['contest_id']);
		$data['question'] = $this->ask_pro->get_all_que($data['contest_id']);
		$this->load->model('oj_con_model','oj_con');
		for ($i = 0; $i < $data['question_sum']; $i++) {
			$result = $this->oj_con->get_username($data['question'][$i]['ask_user_id']);
			$data['question'][$i]['username'] = $result['username'];
		}
		header('Content-Type:text/html;charset=utf-8');
		//p($data);die;
		$this->load->view('contest/ask_pro.html',$data);
	}

	//提交问题
	public function ask_question() {
		$data['contest_id'] = $this->input->post('contest_id',TRUE);
		$data['user_id'] = $this->input->post('user_id',TRUE);
		$data['content'] = $this->input->post('content',TRUE);
		if(!empty($data['content'])) {
			$result = $this->ask_pro->ask_question($data);
			header('Content-Type:text/html;charset=utf-8');
			if($result) success('/contest/ask_pro/index/'.$data['contest_id'],'提问成功！等待管理员回复！');
			else error('提问失败！');
		}
		else {
			error('提问内容不能为空');
		}
	}

}
?>