<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-5-26)
*/
class Contest extends Admin_Controller {

	function __construct() {
		parent::__construct();
		//$this->load->model('contest_model');
	}

	public function index() {
		$this->load->view('admin/contest.html');
	}

	public function contest_add() {
		$this->load->view("admin/contest_add.html");
	}
}
?>