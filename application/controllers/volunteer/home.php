<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Volunteer_Controller{
	 #载入志愿者送球页面
	function index() {
		//$data['session'] = $this->session->userdata('item');
		$this->load->view('volunteer/index.html');		
	}
}
