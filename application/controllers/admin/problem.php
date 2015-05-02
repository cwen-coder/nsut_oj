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
		$data['num'] = $this->problem_model->problem_all_num();
		$data['problem'] = $this->problem_model->problem_list();	
		$this->load->view('admin/problem.html',$data);
	}
}

?>