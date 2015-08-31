<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.05.19]
*/
class Problem_submit extends Oj_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('problemsubmit_model','ps');
	}
	function index(){
		$data['user_id'] = $this->session->userdata('user_id');
		if($data['user_id'] == null){
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('请先登录 ');history.go(-1); </script>";
		}else{

			$data['source'] =base64_decode($this->input->post('source'));
			$data['language'] = $this->input->post('language', TRUE);
			$data['pid'] = $this->input->post('pid', TRUE);
			$data['ip'] = $this->session->userdata('ip_address');
			$data['code_length'] = strlen($data['source']);
			//p($data['ip']);die;
			/*echo $data['code_length'];die;*/
			$result = $this->ps->problem_submit($data);
			$url = 'oj_index/home/status';
			if($result) success($url);
		}
	}
	function compileinfo(){
		$solution_id = $this->input->post('solution_id');
		//echo $solution_id;
		$data = $this->ps->compileinfo($solution_id);
		echo $data['error'];
	}
	function source(){
		$solution_id = $this->input->post('solution_id');
		$data = $this->ps->source($solution_id);
		echo $data['source'];
	}
}