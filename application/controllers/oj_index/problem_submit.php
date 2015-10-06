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
			$this->load->model('problem_model','pro');
			$result = $this->pro->get_pro_hide( $this->input->post('pid', TRUE));
			/*p($result['hide'] != 1);die;*/
			if($result == false) {
				redirect('oj_index/home/index');
			} else if($result['hide'] == 1 && $this->session->userdata('privilege') != 1) {
				redirect('oj_index/home/index');
			}

			$data['source'] = base64_decode($this->input->post('source',true));
			//$data['source'] = stripslashes($data['source']);
			if(get_magic_quotes_gpc()){
				$data['source']=stripslashes($data['source']);//删除由 addslashes() 函数添加的反斜杠
			}
			$data['source'] = mysql_real_escape_string($data['source']);//转义 SQL 语句中使用的字符串中的特殊字符

			$data['language'] = $this->input->post('language', TRUE);
			$data['pid'] = $this->input->post('pid', TRUE);
			$data['ip'] = $this->session->userdata('ip_address');
			$data['code_length'] = strlen($data['source']);
			//p($data);die;
			//echo $data['source'];
			//echo $this->input->post('source',true);
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