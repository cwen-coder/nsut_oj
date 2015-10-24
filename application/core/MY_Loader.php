<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader{

	#开启前台view
	public function switch_view_on(){
		$this->_ci_view_paths = array(FCPATH.INDEX	=> TRUE);
	}

	#关闭前台view
	public function switch_view_off(){
		//just do noing
	}
}