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
		if($data['con_class'] != 2) $data['con_pwd'] = NULL;
		if($data['con_class'] == 1 || $data['con_class'] == 2) {
			$data['p_s_time'] = NULL;
			$data['p_e_time'] = NULL;
		}
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
	//载入比赛编辑
	public function contest_edit() {
		$contest_id = $this->uri->segment(4);
		$data['contest'] = $this->contest_model->get_contest_id($contest_id);
		//p($data);
		$this->load->view('admin/contest_edit.html',$data);
	}

	//比赛编辑动作
	public function con_edit_act() {
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
		if($data['con_class'] != 2) $data['con_pwd'] = NULL;
		if($data['con_class'] == 1 || $data['con_class'] == 2) {
			$data['p_s_time'] = NULL;
			$data['p_e_time'] = NULL;
		}
		$result = $this->contest_model->edit_act($data);
		if($result) {
			success('admin/contest/index','修改成功');
		} else {
			error("修改失败");
		}
	}	

	//载入比赛题目列表页
	public function con_pro_list() {
		$contest_id = $this->uri->segment(4);
		//$data['con_pro'] = $this->contest_model->get_contest_id($contest_id);
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
		//p($data['pro']);
		//p($data['arr']);
		$this->load->view("admin/con_pro_list.html",$data);
	}

	//载入从来自题库页
	public function con_pro_from() {
		$data['contest_id'] = $this->uri->segment(4);
		$data['pro_num'] = $this->uri->segment(5);
		$this->load->model('problem_model');
		$data['num'] =  $this->problem_model->problem_all_num();
		//后台设置后缀为空，否则分页出错
		$this->config->set_item('url_suffix', '');
		//载入分页类
		$this->load->library('pagination');
		$perPage = 3;

		//配置项设置
		$config['base_url'] = site_url('admin/contest/con_pro_from/'.$data['contest_id'].'/'.$data['pro_num']);
		$config['total_rows'] = $data['num'];
		$config['per_page'] = $perPage;
		$config['uri_segment'] = 6;
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '尾页';
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active"><a>'; // 当前页开始样式   
		$config['cur_tag_close'] = '</a></li>'; 

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();	
		//p($data['links']);die;
		$offset = $this->uri->segment(6);
		if($offset < 1 ) $offset = 0;
		//$this->db->limit($perPage, $offset);
		$data['problem'] = $this->problem_model->problem_list($perPage, $offset);
		$this->load->view("admin/con_pro_from.html",$data);
	}
	//为比赛添加来自题库的题目
	public function add_pro_list() {
		$data = array(
				'contest_id' => $this->input->post('contest_id',TRUE),
				'num' => $this->input->post('pro_num',TRUE),
				'problem_id' => $this->input->post('problem_id',TRUE),
				'title' => $this->input->post('title',TRUE),
				'source' => 1
			);
		$result = $this->contest_model->add_pro_list($data);
		echo $result;
	}

	/*public function back_pro_list() {
		self::con_pro_list();
	}*/
}
?>