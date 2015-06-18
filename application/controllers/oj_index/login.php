<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author Yin_CW <[email address]>
* @copyright [2015.04.14]
*/
class Login extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }
	/**
	 * 验证码
	 */
	public function code () {
		//echo "jsdofjjdf";

		$config = array(
			'width'	=>	100,
			'height'=>	25,
			'codeLen'=>	1,
			'fontSize'=>16
			);
		$this->load->library('code', $config);

		$this->code->show();

	}

	public function log_act () {
		//$this->output->enable_profiler(TRUE);
		if(!isset($_SESSION)){
            session_start();
        }
		$captcha = $this->input->post('captcha',TRUE);
		if (strtolower($captcha) !=  strtolower($_SESSION ['code'])) {
			//echo strtolower($captcha)."\n";
			//echo strtolower($_SESSION ['code']);
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
                 'rules' => 'required  | min_length[6] | max_length[32] | xss_clean '
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
        	//$this->load->library('encrypt');
        	$username = $this->input->post('username',TRUE);
			$password = $this->input->post('password',TRUE);
			//$captcha = $this->input->post('captcha',TRUE);
        	$this->load->helper('date');
        	$format = 'DATE_W3C';
			$time = standard_date($format, time());
			$ip = $this->input->ip_address();
        	$data = array(
        		'username' => $username,
        		'password' => $password,
        		'ip' => $ip,
        		'SAC' => $this->input->server('HTTP_USER_AGENT'),
        		'time' => $time
        		);
        	
        	$result = $this->user_model->log_act ($data);
        	//echo $result;
        	if ($result == false) {
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
	public function user_info(){
		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
		$this->load->view('oj_index/user.html',$data);
	}
}

?>
