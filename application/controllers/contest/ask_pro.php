<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.06.10]
*/
class Ask_pro extends Con_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('ask_que_model','ask_pro');
		$this->load->model('oj_con_model','oj_con');
	}

	//载入比赛提问页面
	public function index() {


		$data['contest_id'] = $this->uri->segment(4);

		$contest = $this->oj_con->con_byId($data['contest_id']);
		if($this->session->userdata('privilege') != 1) {
			if($contest['con_class'] == 2 && (!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $contest['con_pwd'])) {
					$offset = $this->uri->segment(5);
					//echo 2;
					redirect('oj_index/home/contest_list/'.$offset.'/1001/'.$contest_id);
			}else if (time() < strtotime($contest['start_time'])) {
					redirect('contest/home/index/'.$data['contest_id']);
			}
		}
		//$ask_pro = $this->ask_pro->get_all_que($data['contest_id']);
		//p($ask_pro);die;
		$data['question_sum'] = $this->ask_pro->get_que_sum($data['contest_id']);

		//后台设置后缀为空，否则分页出错
		$this->config->set_item('url_suffix', '');
		//载入分页类
		$this->load->library('pagination');
		$perPage = 12;
		//配置项设置
		$config['base_url'] = site_url('contest/ask_pro/index/'.$data['contest_id'].'/');
		$config['total_rows'] = $data['question_sum'];
		$config['per_page'] = $perPage;
		$config['uri_segment'] = 5;
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '尾页';
		$config['full_tag_open'] = '';
		$config['full_tag_close'] = '';
		$config['cur_tag_open'] = '<li class="active"><a>'; // 当前页开始样式   
		$config['cur_tag_close'] = '</a></li>'; 

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();	
		$offset = $this->uri->segment(5);
		if($offset < 1) $offset = 0;
		//$this->db->limit($perPage, $offset);
		//$data['con_pass'] = $this->oj_con->con_pass_list($perPage, $offset);
		$data['question'] = $this->ask_pro->get_all_que($data['contest_id'],$perPage,$offset);
		$this->load->model('oj_con_model','oj_con');
		$sum = count($data['question']);
		for ($i = 0; $i < $sum; $i++) {
			$result = $this->oj_con->get_username($data['question'][$i]['ask_user_id']);
			$data['question'][$i]['username'] = $result['username'];
			if($data['question'][$i]['ans_num'] > 0) {
				$answer = $this->ask_pro->get_answer($data['question'][$i]['id']);
				$data['question'][$i]['answer'] = $answer;
			}
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