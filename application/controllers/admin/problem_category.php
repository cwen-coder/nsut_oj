<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_category extends  Admin_Controller {
	function __construct(){
		parent::__construct();
		//$this->load->modle();
	}

	function index(){
		$date['name'] = "admin";
		/*$this->load->model('user_model');
		$date['num'] = $this->user_model->check_username('admin');*/
		$this->load->view('admin/problem_category.html',$date);
	}
	function add_category(){
		$problem_category = $this->input->post('problem_category',TURE);
		echo $problem_category;
	}
}
?>