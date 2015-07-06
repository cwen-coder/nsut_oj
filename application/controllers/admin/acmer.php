<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-7-5)
*/
class Acmer extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('acmer_model','acmer');
	}

	public function index() {
		$data['acmer'] = $this->acmer->get_all_acmer();
		$this->load->view('admin/acmer.html',$data);
	}

	public function user_search() {
		$username = $this->input->post('username');
		$result = $this->acmer->user_search($username);
		if($result == false) echo false;
		else {
			echo json_encode($result);
		}
		//echo 1;
	}

	public function user_check() {
		$user_id = $this->input->post('user_id');
		$result = $this->acmer->user_check($user_id);
		echo $result;
	}

	public function acmer_add() {
		$data['poj_name'] = $this->input->post('poj_name');
		$data['hdoj_name'] = $this->input->post('hdoj_name');
		$data['cf_name'] = $this->input->post('cf_name');
		$data['user_id'] = $this->input->post('hide_user_id');
		$data['user_name'] = $this->input->post('hide_user_name');
		//p($data);
		$result = $this->acmer->acmer_add($data);
		if($result == true)
			success('admin/acmer', '添加成功');
		else 
			error("添加失败！");
	}


	public function acmer_del() {
		$name = $this->input->post('name');
		$result = $this->acmer->acmer_del($name);
		echo $result;
	}
}
?>