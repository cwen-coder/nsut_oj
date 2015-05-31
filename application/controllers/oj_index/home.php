<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Oj_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->model('problem_model','pro');
		$this->load->model('problemsubmit_model','ps');
	}
	//载入主页
	public function index(){
		$total_rows = $this->pro->problem_all_num();
		$config['base_url'] = site_url('oj_index/home/index');   
		$config['total_rows'] = $total_rows;//记录总数，这个没什么好说的了，就是你从数据库取得记录总数   
		$config['per_page'] = 2; //每页条数。额，这个也没什么好说的。。自己设定。默认为10好像。   
		$config['first_link'] = '首页'; // 第一页显示
		$config['last_link'] = '末页'; // 最后一页显示   
		$config['next_link'] = '下一页 >'; // 下一页显示   
		$config['prev_link'] = '< 上一页'; // 上一页显示   
		$config['full_tag_open'] = '';
		$config['full_tag_close'] = '';
		$config['cur_tag_open'] = '<li><a style="color:white;background-color:black">'; // 当前页开始样式   
		$config['cur_tag_close'] = '</a></li>'; 
        		$config['num_links'] = 20;//    当前连接前后显示页码个数。意思就是说你当前页是第5页，那么你可以看到3、4、5、6、7页。   
        		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$data['offset'] = $this->uri->segment(4);
		if($data['offset'] == null) $data['offset']=0;
		$data['category']=$this->pro->problem_list($config['per_page'], $data['offset']);
		$this->load->view('oj_index/problem_list.html',$data);
	}
	//显示题目具体内容
	public function problem(){
		$pid=$this->input->get('pid', TRUE);
		$data['problem']=$this->pro->get_problem_id($pid);
		$this->load->view('oj_index/problem.html',$data);
	}
	//比赛列表显示
	public function contest_list(){
	 	$this->load->view('oj_index/contest_list.html');
	}
	//提交状态显示
	public function status(){
		$data['judge_result']=Array("Pending", "Pending Rejudging", "Compiling", "Running & Judging", "Accepted", "Presentation Error", "Wrong Answer", "Time Limit Exceed", "Memory Limit Exceed", "Output Limit Exceed", "Runtime Error", "Compile Error", "Compile OK","Test Running Done");
		$data['judge_color']=Array("btn_status gray","btn_status btn-info","btn_status btn-warning","btn_status btn-warning","btn_status btn-success","btn_status btn-danger","btn_status btn-danger","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-info");
		$limit=0;
		$data['top'] = $this->input->get('top');
		$data['prevtop'] = $this->input->get('prevtop');
		$data['str'] = $data['prevtop'];
		$data['bottom'] = $data['prevtop'];
		$num=20;
		$data['result'] = $this->ps->problem_status($limit, $num);
	 	$this->load->view('oj_index/status.html', $data);
	}
	//提交页面显示
	public function submitpage(){
		$username = $this->session->userdata('username');
		if($username == null){
			self::problem();
			echo "<script type='text/javascript'>window.onload=function(){document.getElementById('signin').click();}</script>";
		}else{
			$data['pid'] = $this->input->get('pid', TRUE);
			$this->load->view('oj_index/submitpage.html', $data);
		}
	}
}