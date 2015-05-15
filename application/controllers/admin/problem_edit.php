<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[CWen_Yin@qq.com]>
* @date(2015-5-15)
*/
class Problem_edit extends Admin_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('problem_model');
	}

	public function pro_edit() {
		$problem_id = $this->uri->segment(4);
		$data['problem'] = $this->problem_model->get_problem_id($problem_id);
		$data['class'] = $this->problem_model->get_class();
		$this->load->view('admin/problem_edit.html',$data);
	}
}

?>