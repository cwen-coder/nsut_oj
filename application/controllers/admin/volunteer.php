<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-8-31)
*/

class Volunteer extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('volunteer_model','volunteer');
	}

	public function index() {
		$this->load->view('admin/volunteer.html');
	}
}

?>