<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-5-26)
*/
class Contest extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('contest_model');
	}

	public function index() {
		$this->load->view('admin/contest.html');
	}

	public function contest_add() {
		$data['con_id'] = $this->contest_model->get_max_id();
		//p($data['con_id']['MAX(contest_id)']);
		if ($data['con_id']['MAX(contest_id)'] == false) {
			$data['con_id']['MAX(contest_id)'] = 1000;
		} else {
			$data['con_id']['MAX(contest_id)'] += 1;
		}
		//p($data['con_id']['MAX(contest_id)']);
		$this->load->view("admin/contest_add.html",$data);
	}

}
?>