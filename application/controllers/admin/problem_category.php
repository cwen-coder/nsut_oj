<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_category extends  Admin_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Problemcategory_model','cate');
	}
	//
	function index(){
		$data['category'] = $this->cate->check();
		$this->load->view('admin/problem_category.html', $data);
	}
	//
	function add_category(){
		$problem_category = $this->input->post('problem_category',TRUE);
		$result = $this->cate->add($problem_category);
		$data['category'] = $this->cate->check();
		$this->load->view('admin/problem_category.html', $data);
	}
	//
	function delete_category(){
		$cid = $this->input->post('cid');
		$result = $this->cate->delete($cid);
		$data['category'] = $this->cate->check();
		$this->load->view('admin/problem_category.html', $data);
	}
	function edit_category(){
		$cid = $this->input->post('cid');
		$result = $this->cate->edit($cid);
		$data['category'] = $this->cate->check();
		$this->load->view('admin/problem_category.html', $data);
	}
}
?>