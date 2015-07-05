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
		$this->load->view('admin/acmer.html');
	}

	public function user_search() {
		$username = $this->input->post('username');
		$result = $this->acmer->username($username);
	}
}
?>