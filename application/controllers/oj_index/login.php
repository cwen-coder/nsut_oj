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
		if($captcha == "undefined"){
			if(!isset($_SESSION['fs'])){
				$_SESSION['fs'] = 0;
			}
			$_SESSION ['fs'] ++;
			$captcha = $_SESSION ['code'];
		}
		if (strtolower($captcha) !=  strtolower($_SESSION ['code'])) {
			//echo strtolower($captcha)."\n";
			//echo strtolower($_SESSION ['code']);
			echo 2;
		} 

		else {
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
			        		session_destroy();
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
		$data['user'] = $this->input->get('username');
                                   $data['user_info'] = $this->user_model->user($data['user']);
                                   $data['user_ac'] = $this->user_model->user_ac($data['user']);
                                   $data['user_info']['ac_sum'] = sizeof($data['user_ac']);
                                   $data['user_info']['user_problem'] = array();
                                   foreach ($data['user_ac'] as $v):
                                            if(isset($data['user_info']['user_problem'][$v['problem_id']]['ac_num']))
                                                $data['user_info']['user_problem'][$v['problem_id']]['ac_num'] +=1;
                                            else{
                                                $data['user_info']['user_problem'][$v['problem_id']]['ac_num']=1;
                                            }
                                   endforeach;
                                   foreach($data['user_info']['user_problem'] as $key => $val):
                                       $data['user_info']['user_problem'][$key]['sub_sum'] = $this->user_model->user_pro_sub_num($data['user'],$key); 
                                   endforeach;
                                   $data['user_info']['sol_sum'] = sizeof($data['user_info']['user_problem']);
                                   $data['user_info']['submit'] = $this->user_model->user_sub_num($data['user']); 
                                   $rank = $this->user_model->user_rank_all();
                                   $data['user_info']['rank'] = 1;
                                   foreach ($rank as $v):
                                       if($v['username'] == $data['user'])
                                           break;
                                       $data['user_info']['rank'] += 1;
                                   endforeach;
                                   $data['submit'] = $this->user_model->user_sub_all($data['user']);
                                   $solved =$data['user_ac'];
                                   //$data['unsolved'] = array_intersect($submit, $solved);
                                   foreach ($data['submit'] as $key => $value) {
                                    if(!in_array($value,$solved)){
                                        $unsolved[]=$value;
                                    }
                                  }
                                  $data['unsolved'] = array();
                                  foreach ($unsolved as $key => $value) {
                                    if(!in_array($value,$data['unsolved'])){
                                        $data['unsolved'][]=$value;
                                    }
                                  }
                                  $j=0;
                                  foreach($data['unsolved'] as $v):
                                       $data['unsolved'][$j++]['sub_sum'] = $this->user_model->user_pro_sub_num($data['user'],$v['problem_id']); 
                                  endforeach;
                                   //p($data);die;
		$this->load->view('oj_index/user.html',$data);
	}
}

?>
