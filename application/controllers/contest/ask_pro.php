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
		$this->load->view('contest/ask_pro.html',$data);
	}

	//提交问题
	public function ask() {
		$contest_id = $this->input->post('contest_id',TRUE);
		$user_id = $this->input->post('user_id',TRUE);
		$contest = $this->input->post('content',TRUE);
	}
}
?>