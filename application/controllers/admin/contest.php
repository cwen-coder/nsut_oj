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
		$data['now'] = date('Y-m-d H:i:s',time());
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
	//删除比赛题目
	public function del_con_pro() {
		$contest_id = $this->input->post('contest_id',TRUE);
		$num = $this->input->post('num',TRUE);
		$problem_id = $this->input->post('problem_id',TRUE);
		$source = $this->input->post('source',TRUE);
		if($source==1) 
			$result = $this->contest_model->del_con_pro($contest_id,$num);
		else 
			$result = $this->contest_model->new_problem_del($problem_id);

		echo $result;
	}
	//载入添加题目页面
	public function con_pro_add(){
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$data['cid'] = $this->input->get('cid');
		$data['pid'] = $this->input->get('pid');
		$this->load->view('admin/contest_problem_add.html', $data);
	}
	//创建文件夹
	public function create_dir($problem_id){
			$path="/home/judge/data/$problem_id";
			//echo $path."<br/>";
			if(!file_exists($path)){
				if(mkdir($path)) return true;
					else
						return false;
			}
			else 
				return true;

	}
	//上传文件
	public function upload($file_name, $name, $problem_id){
		$config['allowed_types'] = 'txt';
		$config['max_size'] = '1024';
		$config['file_name'] = $file_name;
		$config['upload_path'] = "/home/judge/data/$problem_id";
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$file_path = "$config[upload_path]/$file_name.txt";
		//echo $file_path;
		if (file_exists($file_path) ){ 
            			unlink($file_path);
        		}
		if($this->upload->do_upload($file_name)){
			$a = "/home/judge/data/$problem_id/$file_name.txt";
			$b = "/home/judge/data/$problem_id/$name";
			rename($a, $b);
			//p($this->upload->data());
			return true;
		}
		else{
			echo $this->upload->display_errors();
			return false;
		}
	}
	//输入输出样例写入
	public function write_file($path_,$content){
		$path = "/home/judge/data/$path_";
		if(file_put_contents($path, $content)) return true;
			else return false;
	}
	//添加新题目动作
	public function con_pro_add_do(){
		$data = array(
			'pro_id' => time(),
			'pro_title' => $this->input->post('pro_title'),
			'contest_id' => $this->input->post('cid'),
			'num' => $this->input->post('num'),
			'time_limit' => $this->input->post('time_limit'),
			'memory_limit' => $this->input->post('memory_limit'),
			'content_des' => $this->input->post('content_des'),
			'content_input' => $this->input->post('content_input'),
			'content_output' => $this->input->post('content_output'),
			'sample_input' => $this->input->post('sample_input'),
			'sample_output' => $this->input->post('sample_output'),
			'hint' => $this->input->post('hint'),
			'source' => $this->input->post('source'),
			'spj' => $this->input->post('spj')
			);
		$url = "admin/contest/con_pro_list/$data[contest_id]";
		if($problem_id = $this->contest_model->add_pro_new($data)){
				if(!self::create_dir($problem_id)) error_link($url, "创建文件夹失败");
				if(!self::write_file($problem_id."/sample.in", $data['sample_input'])) error_link($url, "sample.in和sample.out创建失败");
				if(!self::write_file($problem_id."/sample.out", $data['sample_output'])) error_link($url, "sample.out创建失败");
				if(!empty($_FILES['text_out']['tmp_name'])){
					if(!self::upload('text_out', 'text.out', $problem_id)) error_link($url, "text_out和text_in上传失败");
				}
				if(!empty($_FILES['text_out']['tmp_name'])){
					if(!self::upload('text_in', 'text.in', $problem_id)) error_link($url, "text_in上传文件失败");
				}
				success($url, '添加成功');
			}
		else{
			error_link($url, "题目插入失败");
		}
		
	}
	//展示比赛题目修改页面
	public function con_pro_edit(){
		$problem_id = $this->uri->segment(4);
		$data= $this->contest_model->check_con_pro($problem_id);
		$arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$data = array_merge(array('arr'=>$arr),$data);
		//p($data);die;
		$this->load->view("admin/contest_problem_edit.html",$data);

	}
	//修改新增题目动作
	public function con_pro_edit_do(){
		$data = array(
			'pro_id' => $this->input->post('pid'),
			'pro_title' => $this->input->post('pro_title'),
			'contest_id' => $this->input->post('cid'),
			'num' => $this->input->post('num'),
			'time_limit' => $this->input->post('time_limit'),
			'memory_limit' => $this->input->post('memory_limit'),
			'content_des' => $this->input->post('content_des'),
			'content_input' => $this->input->post('content_input'),
			'content_output' => $this->input->post('content_output'),
			'sample_input' => $this->input->post('sample_input'),
			'sample_output' => $this->input->post('sample_output'),
			'hint' => $this->input->post('hint'),
			'source' => $this->input->post('source'),
			'spj' => $this->input->post('spj')
			);
		//p($data);die;
		$url = "admin/contest/con_pro_list/$data[contest_id]";
		if($problem_id = $this->contest_model->edit_pro_new($data)){
				if(!self::create_dir($problem_id)) error_link($url, "创建文件夹失败");
				if(!self::write_file($problem_id."/sample.in", $data['sample_input'])) error_link($url, "sample.in和sample.out创建失败");
				if(!self::write_file($problem_id."/sample.out", $data['sample_output'])) error_link($url, "sample.out创建失败");
				if(!empty($_FILES['text_out']['tmp_name'])){
					if(!self::upload('text_out', 'text.out', $problem_id)) error_link($url, "text_out和text_in上传失败");
				}
				if(!empty($_FILES['text_out']['tmp_name'])){
					if(!self::upload('text_in', 'text.in', $problem_id)) error_link($url, "text_in上传文件失败");
				}
				success($url, '题目修改成功');
			}
		else{
			error_link($url, "题目修改失败");
		}
	}
}?>