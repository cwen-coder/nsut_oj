<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author Yin_CW <[email address]>
* @copyright [2015.04.09]
*/
class Register extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}
	/**
	 * 获取ajax传回数据验证是否存在
	 * @access public
	 * @return  
	 */
	public function username_check() {
		$username = $this->input->post('username',TRUE);
		$result = $this->user_model->check_username($username);
		if($result > 0)
			echo false;
		else 
			echo true;
	}

	//获取ajax传回数据验证是否存在
	public function email_check() {
		$email = $this->input->post('email',TRUE);
		$result = $this->user_model->check_email($email);
		if($result > 0)
			echo false;
		else 
			echo true;
	}

	//注册
	public function reg_act() {
		$this->load->library('form_validation');
        		$status = $this->form_validation->run('register');
        		if($status == false )  return false;
        		else{
        			$username = $this->input->post('username',TRUE);
        			$password1 = $this->input->post('password1',TRUE);
        			$password2 = $this->input->post('password2',TRUE);
        			$email = $this->input->post('email',TRUE);

        		}
        		
	}
}