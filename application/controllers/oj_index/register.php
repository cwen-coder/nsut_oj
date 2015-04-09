<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author Yin_CW <[email address]>
* @copyright [2015.04.09]
*/
class Register extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}

	public function username_post(){
		$username = $this->input->post('username');
		$result = $this->user_model->check_username($username);
		return $result;
	}
}