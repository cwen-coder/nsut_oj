<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Oj_Controller{
	function __construct(){
		parent::__construct();
	}
	//载入主页
	public function exercise(){
		$this->load->view('oj_index/exercise.html');
	}
}