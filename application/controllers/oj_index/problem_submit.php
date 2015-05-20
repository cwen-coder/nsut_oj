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
			error('请先登录');
		}else{
			$data['source'] = $this->input->post('source', TRUE);
			$data['pid'] = $this->input->post('pid', TRUE);
			$data['ip'] = $this->session->userdata('ip_address');
			$result = $this->ps->problem_submit($data);
		}
	}
}