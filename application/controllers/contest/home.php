<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Oj_Controller{
	public function index(){
		$this->load->view('contest/contest.html');
	}
}