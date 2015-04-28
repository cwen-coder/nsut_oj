<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Oj_Controller{
	//载入主页
	public function index(){
 		$this->load->view('oj_index/index.html');
	}
}