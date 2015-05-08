<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-4-28)
*/
class Problem extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('problem_model');
	}
	
	public function index() {
		$data['num'] =  $this->problem_model->problem_all_num();
		//后台设置后缀为空，否则分页出错
		$this->config->set_item('url_suffix', '');
		//载入分页类
		$this->load->library('pagination');
		$perPage = 3;

		//配置项设置
		$config['base_url'] = site_url('admin/problem/index');
		$config['total_rows'] = $data['num'];
		$config['per_page'] = $perPage;
		$config['uri_segment'] = 4;
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '最后一页';
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active"><a>'; // 当前页开始样式   
		$config['cur_tag_close'] = '</a></li>'; 

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();	
		//p($data['links']);die;
		$offset = $this->uri->segment(4);
		if($offset < 1) $offset = 0;
		//$this->db->limit($perPage, $offset);
		$data['problem'] = $this->problem_model->problem_list($perPage, $offset);
		$this->load->view('admin/problem.html',$data);
	}

	/*public function get_problem() {
		$data = $this->problem_model->problem_list();
	}*/

	//删除题目
	public function problem_del() {
		$problem_id = $this->input->post('problem_id',TRUE);
		$result = $this->problem_model->problem_del($problem_id);
		if($result) echo true;
		else echo false;
	}

	//添加题目
	public function problem_add() {
		$data['max_id'] = $this->problem_model->get_max_id();
		$data['class'] = $this->problem_model->get_class();
		$this->load->view('admin/problem_add.html',$data);
	}

	//ajax检查题号
	public function check_id() {
		$problem_id = $this->input->post('problem_id',TRUE);
		$result = $this->problem_model->check_id($problem_id);
		if($result > 0 ) echo false;
		else echo true;
	}
}

?>