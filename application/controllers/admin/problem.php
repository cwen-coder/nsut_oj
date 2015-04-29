<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-4-28)
*/
class Problem extends Admin_Controller{

	function __construct(){
		parent::__construct();
		//$this->load->modle();
	}
	
	public function index() {
		$this->load->view('admin/problem.html');
	}
}

?>