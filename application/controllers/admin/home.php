<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller{
	#载入后台模板
	function index(){
		$this->load->view('admin/index.html');
	}
}
