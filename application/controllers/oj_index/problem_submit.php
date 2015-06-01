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
			$data['language'] = $this->input->post('language', TRUE);
			$data['pid'] = $this->input->post('pid', TRUE);
			$data['ip'] = $this->session->userdata('ip_address');
			$data['code_length'] = strlen($data['source']);
			/*echo $data['code_length'];die;*/
			$result = $this->ps->problem_submit($data);
			$url = 'oj_index/home/status';
			if($result) success('$url','提交成功');
		}
	}
	/**
	 * memcache调用 
	 */
	function memcache(){
		$this->load->library('CI_Memcache');
		$mem = new CI_Memcache();
		$mem->mc = $mem->init();
		$key = 'admin_memcache';
		if($mem->mc->get( $key ))
			echo $mem->mc->get( $key );
		else{
			echo 'normal';
		}
		$mem->mc->set($key, time());
		//$mem->mc->delete($key,0);
	}
}