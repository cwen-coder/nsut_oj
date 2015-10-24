<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilege extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }
	//载入登录页
	function index() {
		$this->load->view('admin/sign-in.html');
	}

	/**
	 * 验证码
	 */
	public function code () {
		//echo "jsdofjjdf";

		$config = array(
			'width'	=>	100,
			'height'=>	25,
			'codeLen'=>	4,
			'fontSize'=>16
			);
		$this->load->library('code', $config);

		$this->code->show();

	}


	public function log_act () {
		if (!isset($_SESSION)) {
			session_start();
		}

		$captcha = $this->input->post('captcha',TRUE);
		if (strtolower($captcha) !=  strtolower($_SESSION ['code'])) {
			echo 2;
		} else {
			$this->load->library('form_validation');
			$config = array (
			array (
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'required | min_length[6] | max_length[32] | alpha_numeric | xss_clean '
				),
			array (
                 'field' => 'password',
                 'label' => '密码',
                 'rules' => 'required  | min_length[6] | max_length[32] | xss_clean'
                 ),
			array (
				'field' => 'captcha',
				'label' => '验证码',
				'rules' => 'required | xss_clean'
				)
			);
			$this->form_validation->set_rules($config);
        	$status = $this->form_validation->run();
        	if($status == false) {
        		echo false;
        	} else {

        		$username = $this->input->post('username',TRUE);
			$password = $this->input->post('password',TRUE);
			//$captcha = $this->input->post('captcha',TRUE);
        	$this->load->helper('date');
        	$format = 'DATE_W3C';
			$time = standard_date($format, time());
			$ip = $this->input->ip_address();
        	$data = array(
        		'username' => mysql_real_escape_string($username),
        		'password' => mysql_real_escape_string($password),
        		'ip' => $ip,
        		'SAC' => $this->input->server('HTTP_USER_AGENT'),
        		'time' => $time
        		);
        	
        	$result = $this->user_model->log_act ($data);
        	//echo $result;
        	if ($result == false) {
        		echo false;
        	} else if ($result['privilege'] != 1) {
        		echo false;
        	} else {
        		$newdata = array (
        			'user_id' => $result['user_id'],
        			'username' => $username,
        			'ip' => $ip,
        			'time' => $time,
        			'privilege' => $result['privilege']
        			);
        		$this->session->set_userdata($newdata);
        		echo true;
        	}

        }
		}
	}

	public function log_out() {
		$this->session->sess_destroy();
		success('admin/privilege/index','注销成功');
	}

}