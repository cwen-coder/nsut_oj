<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home  extends Index_Controller {
	//载入主页
	public function index (){
		$this->load->view('home.html');
	}

             //载入研发中心
	public function acm_lab(){
		$this->load->view('acm_lab.html');
	}

	//载入时间轴
	public function timeline(){
		$this->load->view('/timeline/index.html');
	}

	//载入关于我们页面
	public function about_us(){
		$this->load->view('about_us.html');
	}
}