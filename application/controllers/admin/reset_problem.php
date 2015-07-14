<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-7-14)
*/ 
class Reset_problem extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('reset_problem_model','reset_pro');
	}

	public function index() {
		$this->load->view('admin/reset_problem.html');
	}
}