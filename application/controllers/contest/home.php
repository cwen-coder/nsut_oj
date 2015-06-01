<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Oj_Controller{
	public function index(){
		$contest_id = $this->uri->segment(4);
		if(!$this->session->userdata('username')) {
			self::contest_list();
			echo "<script type='text/javascript'>window.onload=function(){document.getElementById('signin').click(); }</script>";
		}else {

		}
		//$this->load->view('contest/contest.html');
	}

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
	}

}