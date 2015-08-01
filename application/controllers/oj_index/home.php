<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Oj_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->model('problem_model','pro');
		$this->load->model('problemsubmit_model','ps');
		$this->load->model('user_model');
	}
	//载入主页
	public function index(){
		/*$this->load->model('privilege_model');
		$user_id = $this->session->userdata('user_id');	
		$ip = implode($this->privilege_model->get_ip($user_id));
		p($this->privilege_model->get_ip($user_id));
		p($ip);
		p($this->session->userdata('ip'));
		die;*/
		$total_rows = $this->pro->problem_all_num();
		$config['base_url'] = site_url('oj_index/home/index');   
		$config['total_rows'] = $total_rows;//记录总数，这个没什么好说的了，就是你从数据库取得记录总数   
		$config['per_page'] = 10; //每页条数。额，这个也没什么好说的。。自己设定。默认为10好像。   
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
		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');//$this->pro->problem_check('$data[user_id]','$v[problem_id]')
			$data['user_id'] = $this->session->userdata('user_id');
			foreach($data['category'] as &$v):
				$v = array_merge(array('do'=>$this->pro->problem_check($data['user_id'],$v['problem_id'])), $v);
			endforeach;
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
		$data['cate'] = $this->pro->get_class();
		//p($data);die;
		$this->load->view('oj_index/problem_list.html',$data);
	}
	//显示题目具体内容
	public function problem(){
		$pid=$this->input->get('pid', TRUE);
		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
		$data['problem']=$this->pro->get_problem_id($pid);
		$this->load->view('oj_index/problem.html',$data);
	}
	//比赛列表显示
	public function contest_list(){
		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
		$this->load->model('oj_con_model','oj_con');
		$data['con_now'] = $this->oj_con->get_now_contest();
		//分页获取已结束的比赛
		$data['num'] =  $this->oj_con->pass_con_num();
		//后台设置后缀为空，否则分页出错
		$this->config->set_item('url_suffix', '');
		//载入分页类
		$this->load->library('pagination');
		$perPage = 3;
		//配置项设置
		$config['base_url'] = site_url('oj_index/home/contest_list/');
		$config['total_rows'] = $data['num']['count(*)'];
		$config['per_page'] = $perPage;
		$config['uri_segment'] = 4;
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
		$offset = $this->uri->segment(4);
		if($offset < 1) $offset = 0;
		//$this->db->limit($perPage, $offset);
		$data['con_pass'] = $this->oj_con->con_pass_list($perPage, $offset);
		/*p($data['con_now']);
		p($data['con_pass']);
		die;*/
		//echo $data['links'];die;
	 	$this->load->view('oj_index/contest_list.html',$data);
	 	$offset1 = $this->uri->segment(5);
	 	if($offset1 == 1000 && !$this->session->userdata('username')) {
	 		echo "<script type='text/javascript'>window.onload=function(){document.getElementById('signin').click(); }</script>";
	 	} else if($offset1 == 1001) {
	 		$offset_con = $this->uri->segment(6);
	 		$data['contest'] = $this->oj_con->con_byId($offset_con);
	 		if(!$this->session->userdata('username')) {
	 			echo "<script type='text/javascript'>window.onload=function(){document.getElementById('signin').click(); }</script>";
	 		}else if(!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $data['contest']['con_pwd']){
		 		//echo "<script type='text/javascript'> alert(' ".$offset_con."')</script>";
		 		echo "<script type='text/javascript'>window.onload=function(){document.getElementById('con_log').click();}</script>";
		 	}
	 	}
	}
	//提交状态显示
	public function status(){
		$user = $this->input->get('user', TRUE);
		$pid = $this->input->get('pid', TRUE);
		$ps = $this->input->get('ps', TRUE);

		$data['judge_result']=Array("Pending", "Pending Rejudging", "Compiling", "Running & Judging", "Accepted", "Presentation Error", "Wrong Answer", "Time Limit Exceed", "Memory Limit Exceed", "Output Limit Exceed", "Runtime Error", "Compile Error", "Compile OK","Test Running Done");
		$data['judge_color']=Array("btn_status gray","btn_status btn-info","btn_status btn-warning","btn_status btn-warning","btn_status btn-success","btn_status btn-danger","btn_status btn-danger","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-info");
		$limit=0;
		if($data['pagination'] = $this->input->get('pagination')) 
			$limit = $data['pagination']*20-20;
		if($this->input->get('previous')) 
			$data['previous'] = $this->input->get('previous');
		$num=20;
		if(!empty($pid)) {
			if(!empty($ps)){
				$data['result'] = $this->ps->status_search_pid_ps($limit, $num, $pid);
				$data['ps'] = "accepted";
				$data['pre'] = $this->ps->status_num_pid_ac($pid)[0]/20;
			}
			if(empty($ps)){
				$data['result'] = $this->ps->status_search_pid($limit, $num, $pid);
				$data['pre'] = $this->ps->status_num_pid($pid)[0]/20;
			}
			$data['pid'] = $pid;
		}
		else if(!empty($user)){
			$data['result'] = $this->ps->status_search_user($limit, $num, $user);
			$data['pre'] = $this->ps->status_num_user($user)[0]/20;
			$data['user'] = $user;
			//p($data);die;
		}
		else {
			$data['result'] = $this->ps->problem_status($limit, $num);
			$data['pre'] = $this->ps->status_num()[0]/20;
		}

		$data['pagination'] = $limit/20+2;

		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
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
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
			$this->load->view('oj_index/submitpage.html', $data);
		}
	}
	//注销登录
	public function log_out() {
		$this->session->sess_destroy();
		header('Content-Type:text/html;charset=utf-8');
		echo "<script type='text/javascript'> alert('注销成功 ');history.go(-1); </script>";
	}

	/*public function log_but() {
		self::contest_list();
	}*/
	//按题号查找
	public function search(){
		$pid = $this->input->get('pid', TRUE);
		$pn = $this->input->get('pn', TRUE);
		$pc = $this->input->get('pc', TRUE);
		if(!empty($pid)) 
			$data['category'][0]=$this->pro->search_problem_byId($pid);
		if(!empty($pn)) 
			$data['category'][0]=$this->pro->search_problem_byTitle($pn);
		if(!empty($pc)) 
			$data['category']=$this->pro->search_problem_byClass($pc);
		if(empty($pid)&&empty($pn)&&empty($pc)){
			$total_rows = $this->pro->problem_all_num();
		$config['base_url'] = site_url('oj_index/home/index');   
		$config['total_rows'] = $total_rows;//记录总数，这个没什么好说的了，就是你从数据库取得记录总数   
		$config['per_page'] = 10; //每页条数。额，这个也没什么好说的。。自己设定。默认为10好像。   
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
	}
		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');//$this->pro->problem_check('$data[user_id]','$v[problem_id]')
			$data['user_id'] = $this->session->userdata('user_id');
			if(!empty($data['category'][0])){
			foreach($data['category'] as &$v):
				$v = array_merge(array('do'=>$this->pro->problem_check($data['user_id'],$v['problem_id'])), $v);
			endforeach;
			}
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
		$data['cate'] = $this->pro->get_class();
		//p($data);die;
		$this->load->view('oj_index/problem_list.html',$data);
	}
	public function rank(){
		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
		$data['info'] = $this->user_model->user_rank();
		//p($data['info']);die;
		$this->load->view('oj_index/rank.html', $data);
	}
	public function school_contest(){

		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
			$data['contest'] = $this->user_model->school_contest();
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
                                    if($this->session->userdata('school_contest')){
                                        $data['school_contest'] = $this->session->userdata('school_contest');
                                    }
		 if($a=$this->user_model->check_new_contest()){
			$data['new_contest'] = $a;
			//p($this->user_model->check_new_contest());die;
                                    }
                                    if($b=$this->user_model->check_old_contest()){
			$data['old_contest'] = $b;
                                    }
                                    $data['check_enroll_old'] = true;
                                    $data['check_enroll_new'] = true;
                                   if($data['user_id'] && (isset($data['new_contest']) ||isset($data['old_contest'])) ){
                                                    $data['check_enroll_old'] = $this->user_model->check_enroll($data['user_id'], isset($data['old_contest']['contest_id'])? $data['old_contest']['contest_id'] : '-1');
                                                    $data['check_enroll_new'] = $this->user_model->check_enroll($data['user_id'], isset($data['new_contest']['contest_id'])? $data['new_contest']['contest_id'] : '-1');
                                   }
                                   if($c=$this->user_model->school_info()){
                                                    $data['school_info'] = $c;
                                   }
                                   //p(isset($data['user_id']));die;
		$this->load->view('contest/school_contest.html', $data);
	}
                   public function teams(){
                                   $data['info'] = $this->user_model->teams();
                                   $this->load->view('contest/teams.html', $data);
                   } 
}