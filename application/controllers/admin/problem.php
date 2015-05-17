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

	//按题号创建文件夹
	public function create_dir($problem_id) {
		$OJ_DATA = $this->problem_model->get_oj_data();
		$dir = "$OJ_DATA/$problem_id";
		$result = false;
		if (!file_exists($dir)) { 
                $result = mkdir($dir); 
        }
        return $result;
	}	

	//写入文件操作
	public function write_file($path_, $content) {
		$OJ_DATA = $this->problem_model->get_oj_data();
		$path = "$OJ_DATA/$path_";
		file_put_contents($path,$content);
		if (file_exists($path))
		  	return true;
		else
		  	return false;
	}

	//上传文件动作
	public function do_upload($cof) {
		$config['upload_path'] = $cof['path'];
		$config['allowed_types'] = $cof['types'];
		$config['max_size'] = $cof['max_size'];
		$config['file_name'] = $cof['file_name'];
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		$aimurl = "$cof[path]/$cof[file_name]";
		if (file_exists($aimurl)) { 
            unlink($aimurl); 
        }
		$result = $this->upload->do_upload($cof['name']);
		if($result) return true;
		else {
			 $error = array('error' => $this->upload->display_errors());
			 return $error;
		}
	}


	//题目添加动作
	public function add_act() {
		$data = array(
				'problem_id' => $this->input->post('problem_id',TRUE),
				'title' => $this->input->post('pro_title',TRUE),
				'class_id' => $this->input->post('pro_class',TRUE),
				'time_limit' => $this->input->post('time_limit',TRUE),
				'memory_limit' => $this->input->post('memory_limit',TRUE),
				'description' => $this->input->post('content_des',TRUE),
				'input' => $this->input->post('content_input',TRUE),
				'output' => $this->input->post('content_output',TRUE),
				'sample_input' => $this->input->post('sample_input',TRUE),
				'sample_output' => $this->input->post('sample_output',TRUE),
				'hint' => $this->input->post('hint',TRUE),
				'spj' => $this->input->post('spj',TRUE),
				'source' => $this->input->post('source',TRUE)				
			);
		//echo $_POST['content_des'];
		//p($data);die;
		$result_w_in = false;
		$result_w_out = false;
		$result_in = false;
		$result_out = false;
		$result1 = false;
		$result2 = false;
		
		$OJ_DATA = $this->problem_model->get_oj_data();

		self::create_dir($data['problem_id']);

		//写入sample_in
		if(strlen($data['sample_input'])) {
			$path = "$data[problem_id]/sample.in";
			$result_w_in = self::write_file($path,$data['sample_input']);
		}

		//写入sample_out
		if(strlen($data['sample_output'])) {
			$path = "$data[problem_id]/sample.out";
			$result_w_out = self::write_file($path,$data['sample_output']);
		}

		//上传test_in
		//echo $_FILES['test_in']['tmp_name'];
		if(!empty($_FILES['test_in']['tmp_name'])) {
			$path = "$OJ_DATA/$data[problem_id]";
			$cof_in = array(
				'path' => $path,
				'types' => 'txt',
				'max_size' => '10240',
				'file_name' => 'test_in',
				'name' => 'test_in'
			);
			$result_in = self::do_upload($cof_in);
			if($result_in == true) {
				$a = "$path/test_in.txt";
				$b = "$path/test.in";
				rename($a, $b);
			} else p($result_in);
				//p($result_in);
		}

			//上传test_out
		if(!empty($_FILES['test_out']['tmp_name'])) {
			$path = "$OJ_DATA/$data[problem_id]";
			$cof_out = array(
				'path' => $path,
				'types' => 'txt',
				'max_size' => '10240',
				'file_name' => 'test_out',
				'name' => 'test_out'
			);
			$result_out = self::do_upload($cof_out);
			if($result_out == true) {
				$a = "$path/test_out.txt";
				$b = "$path/test.out";
				rename($a, $b);
			} else p($result_out);
		}
		if(($result_w_in == true || $result_w_in == false) && ($result_w_out == true || $result_w_out == false) 
			&& ($result_in == true || $result_in == false) && ($result_out == true || $result_out == false)) {
			$result1 = $this->problem_model->add_act($data);
			$result2 = $this->problem_model->privilege($this->session->userdata('user_id'),$data['problem_id']);
		}

		if($result1 && $result2) {
			success('admin/problem/index','添加成功');
		} else {
			error("添加失败");
		}
		
	}

	public function pro_edit() {
		$problem_id = $this->uri->segment(4);
		$data['problem'] = $this->problem_model->get_problem_id($problem_id);
		$data['class'] = $this->problem_model->get_class();
		$this->load->view('admin/problem_edit.html',$data);
	}

	public function edit_act() {
		$data = array(
				'problem_id' => $this->input->post('problem_id',TRUE),
				'title' => $this->input->post('pro_title',TRUE),
				'class_id' => $this->input->post('pro_class',TRUE),
				'time_limit' => $this->input->post('time_limit',TRUE),
				'memory_limit' => $this->input->post('memory_limit',TRUE),
				'description' => $this->input->post('content_des',TRUE),
				'input' => $this->input->post('content_input',TRUE),
				'output' => $this->input->post('content_output',TRUE),
				'sample_input' => $this->input->post('sample_input',TRUE),
				'sample_output' => $this->input->post('sample_output',TRUE),
				'hint' => $this->input->post('hint',TRUE),
				'spj' => $this->input->post('spj',TRUE),
				'source' => $this->input->post('source',TRUE)				
			);
		$result_w_in = false;
		$result_w_out = false;
		$result_in = false;
		$result_out = false;
		$result1 = false;
		$result2 = false;
		
		$OJ_DATA = $this->problem_model->get_oj_data();

		//写入sample_in
		if(strlen($data['sample_input'])) {
			$path = "$data[problem_id]/sample.in";
			$result_w_in = self::write_file($path,$data['sample_input']);
		}

		//写入sample_out
		if(strlen($data['sample_output'])) {
			$path = "$data[problem_id]/sample.out";
			$result_w_out = self::write_file($path,$data['sample_output']);
		}

		//上传test_in
		//echo $_FILES['test_in']['tmp_name'];
		if(!empty($_FILES['test_in']['tmp_name'])) {
			$path = "$OJ_DATA/$data[problem_id]";
			$cof_in = array(
				'path' => $path,
				'types' => 'txt',
				'max_size' => '10240',
				'file_name' => 'test_in',
				'name' => 'test_in'
			);
			$result_in = self::do_upload($cof_in);
			if($result_in == true) {
				$a = "$path/test_in.txt";
				$b = "$path/test.in";
				rename($a, $b);
			} else p($result_in);
				//p($result_in);
		}

			//上传test_out
		if(!empty($_FILES['test_out']['tmp_name'])) {
			$path = "$OJ_DATA/$data[problem_id]";
			$cof_out = array(
				'path' => $path,
				'types' => 'txt',
				'max_size' => '10240',
				'file_name' => 'test_out',
				'name' => 'test_out'
			);
			$result_out = self::do_upload($cof_out);
			if($result_out == true) {
				$a = "$path/test_out.txt";
				$b = "$path/test.out";
				rename($a, $b);
			} else p($result_out);
		}
		if(($result_w_in == true || $result_w_in == false) && ($result_w_out == true || $result_w_out == false) 
			&& ($result_in == true || $result_in == false) && ($result_out == true || $result_out == false)) {
			$result1 = $this->problem_model->edit_act($data);
		}

		if($result1) {
			header('Content-Type:text/html;charset=utf-8');
			echo "<script type='text/javascript'> alert('修改成功');history.go(-2); </script>";
		} else {
			error("修改失败");
		}
		
	}
}

?>