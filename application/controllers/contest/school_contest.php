<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_contest extends Oj_Controller{
        function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}
        //参赛信息完善页
        public function enroll(){
            if($this->session->userdata('username') && $this->session->userdata('user_id')){
                                                    $data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
             
            if(!$data['username'] && !$data['user_id']){
                $this->load->view('contest/school_login.html', $data);
            }else{
                        if($a=$this->user_model->check_new_contest()){
                                $data['new_contest'] = $a;
                                //p($this->user_model->check_new_contest());die;
                        }
                        if($b=$this->user_model->check_old_contest()){
                                    $data['old_contest'] = $b;
                          }
                      $data['check_enroll_old'] = true;
                      $data['check_enroll_new'] = true;
                    if($data['user_id'] && (isset($data['new_contest']) ||isset($data['old_contest'])) ){
                                                            $data['check_enroll_old'] = $this->user_model->check_enroll($data['user_id'], isset($data['old_contest']['contest_id'])? $data['old_contest']['contest_id'] : '-1');
                                                            $data['check_enroll_new'] = $this->user_model->check_enroll($data['user_id'], isset($data['new_contest']['contest_id'])? $data['new_contest']['contest_id'] : '-1');
                     }
                     if(!$data['check_enroll_old'] || !$data['check_enroll_new']){
                         echo " Illegal Operation";die;
                     }
                     if (time() < strtotime($data['old_contest']['pre_start_time'])) {
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('报名还没有开始,敬请期待 ');history.go(-1); </script>";
		} else if(time() > strtotime($data['old_contest']['pre_end_time'])){
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('报名已经结束,如有问题请联系管理员');history.go(-1); </script>";
                                }else{
                                            $this->load->view('contest/enroll_page.html', $data);
                                }
            }
        }
        //修改参赛信息页面
        public function updata_enroll(){
            
             if($this->session->userdata('username') && $this->session->userdata('user_id')){
                                                    $data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
            
            if((!$data['username'] && !$data['user_id'])){
                $this->load->view('contest/school_login.html', $data);
                }else{
                        if($a=$this->user_model->check_new_contest()){
			$data['new_contest'] = $a;
			//p($this->user_model->check_new_contest());die;
                        }
                         if($b=$this->user_model->check_old_contest()){
			$data['old_contest'] = $b;
                            }
                        $data['check_enroll_old'] = true;
                        $data['check_enroll_new'] = true;
                        if($data['user_id'] && (isset($data['new_contest']) ||isset($data['old_contest'])) ){
                                                                $data['check_enroll_old'] = $this->user_model->check_enroll($data['user_id'], isset($data['old_contest']['contest_id'])? $data['old_contest']['contest_id'] : '-1');
                                                                $data['check_enroll_new'] = $this->user_model->check_enroll($data['user_id'], isset($data['new_contest']['contest_id'])? $data['new_contest']['contest_id'] : '-1');
                         }
                         if($data['check_enroll_old'] && $data['check_enroll_new']){
                             echo " Illegal Operation";die;
                         }
                            $data['enroll_info'] = $this->user_model->enroll_info($data['user_id'], !$data['check_enroll_old'] ? $data['old_contest']['contest_id'] : $data['new_contest']['contest_id']);
                            if (time() < strtotime($data['old_contest']['pre_start_time'])) {
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('报名还没有开始,敬请期待 ');history.go(-1); </script>";
		} else if(time() > strtotime($data['old_contest']['pre_end_time'])){
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('报名已经结束,如有问题请联系管理员');history.go(-1); </script>";
                                }else{
                                        $this->load->view('contest/updata_enroll.html', $data);
                           }
            }
            
        }
        //修改参赛信息动作
        public function updata_action(){
                    $captcha = mysql_real_escape_string$this->input->post('cap_r', TRUE));
                if (strtolower($captcha) !=  strtolower($_SESSION ['code'])){
                        echo 2;
                        return;
                    }
                  if($a=$this->user_model->check_new_contest()){
                                $new = $a;
                        }
                        if($b=$this->user_model->check_old_contest()){
                                    $old = $b;
                       }
                    $pre_start_time = isset($old['pre_start_time']) ? $old['pre_start_time'] : $new['pre_start_time'] ;
                    $pre_end_time = isset($old['pre_end_time']) ? $old['pre_end_time'] : $new['pre_end_time'] ;
                  if(!($pre_start_time < Now() && $pre_end_time >  Now()) ){
                      echo false;
                      return;
                  }
                $this->load->helper('form');
                $this->load->library('form_validation');
                $config = array(
                    array(
                    'field' => 'username',
                    'label' => '队长姓名',
                    'rules' => 'required | max_length[32] |xss_clean '
                    ),
                    array(
                    'field' => 'usernum',
                    'label' => '队长学号',
                    'rules' => 'required | exact_length[9] | xss_clean '
                    ),
                    array(
                    'field' => 'user1name',
                    'label' => '队员1姓名',
                    'rules' => 'max_length[32] |xss_clean '
                    ),
                    array(
                    'field' => 'user1num',
                    'label' => '队员1学号',
                    'rules' => 'exact_length[9] | xss_clean '
                    ),
                    array(
                    'field' => 'user2name',
                    'label' => '队员2姓名',
                    'rules' => 'max_length[32] |xss_clean '
                    ),
                    array(
                    'field' => 'user2num',
                    'label' => '队员2学号',
                    'rules' => 'exact_length[9] |xss_clean '
                    ),
                    array(
                    'field' => 'teamname',
                    'label' => '队伍名称',
                    'rules' => 'required | max_length[10] | xss_clean '
                    ),
                    array(
                    'field' => 'phone',
                    'label' => '手机号',
                    'rules' => 'required | exact_length[11] | xss_clean '
                    ),
                    array(
                    'field' => 'contest_id',
                    'label' => '比赛类型',
                    'rules' => 'required | exact_length[4] | xss_clean '
                    )
                    );
        $this->form_validation->set_rules($config);
        $status = $this->form_validation->run();
        if(!$status) 
            echo false;
        else{
            $this->load->library('encrypt');
            $this->load->helper('date');
            $format = 'DATE_W3C';
            $contest_id = mysql_real_escape_string($this->input->post('contest_id',TRUE));
            $username = mysql_real_escape_string($this->input->post('username',TRUE));
            $usernum = mysql_real_escape_string($this->input->post('usernnum',TRUE));
            $user1name = mysql_real_escape_string($this->input->post('user1name',TRUE));
            $user1num = mysql_real_escape_string($this->input->post('user1num',TRUE));
            $user2name = mysql_real_escape_string($this->input->post('user2name',TRUE));
            $user2num = mysql_real_escape_string($this->input->post('user2num',TRUE));
            $teamname = mysql_real_escape_string($this->input->post('teamname',TRUE));
            $phone = mysql_real_escape_string($this->input->post('phone',TRUE));
            $user_id = $this->session->userdata('user_id');
            $str = "[^\x80-\xff]";
//            if(eregi($str,$username)){ 
//                echo false;
//                return;
//            } 
            if(!$user_id || $this->user_model->teamname_check($teamname, $contest_id, $user_id) > 0){
                    echo false;
            }  else {
                
                $data = array(
                        'user_id' => $user_id,
                        'contest_id' => mysql_real_escape_string($contest_id),
                        'team_name' => mysql_real_escape_string($teamname),
                        'team_num1' => mysql_real_escape_string($usernum),
                        'team_name1' => mysql_real_escape_string($username),
                        'team_num2' => mysql_real_escape_string($user1num),
                        'team_name2' => mysql_real_escape_string($user1name),
                        'team_num3' => mysql_real_escape_string($user2num),
                        'team_name3' => mysql_real_escape_string($user2name),
                        'phone' => mysql_real_escape_string($phone)
                    );
                //echo $data;
                //$result = true;
                $result = $this->user_model->updata_enroll($data);
                if($result)
                    echo true;
                else
                    echo  false;
            }
    }
        }
        //进入校赛验证
        public function school_login(){
                                    if(!isset($_SESSION)){
                                                        session_start();	
                                                }
		$captcha = mysql_real_escape_string($this->input->post('captcha',TRUE));
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
				              'rules' => 'required  | exact_length[32] | xss_clean '
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
			        	$username = mysql_real_escape_string($this->input->post('username',TRUE));
				$password = mysql_real_escape_string($this->input->post('password',TRUE));
                                                                     $school_info = $this->user_model->school_info();
                                                                     $data0 = array(
                                                                                                        'contest_id' =>  isset($school_info[0]['contest_id'])? $school_info[0]['contest_id'] : '-1',
                                                                                                        'team_password' => $password,
                                                                                                        'username' =>   $username                                                                                                   
                                                                                                        );
                                                                      $data1 = array(
                                                                                                        'contest_id' =>  isset($school_info[1]['contest_id'])? $school_info[1]['contest_id'] : '-1',
                                                                                                        'team_password' => $password,
                                                                                                        'username' =>   $username                                                                                                   
                                                                                                        );
                                                                      
                                                                     $check_enroll1 = $this->user_model->check_teampassword($data0);
                                                                     $check_enroll2 = $this->user_model->check_teampassword($data1);
                                                                     if(!$check_enroll1 && !$check_enroll2){
                                                                          echo false;
                                                                          return;
                                                                     }
//                                                                     if($username == $this->session->userdata('username') ){
//                                                                                    $this->session->set_userdata('school_contest', $data['check_enroll1'] ? $data['check_enroll1'] :$data['check_enroll2']);
//                                                                     }                    
                                                                                    $password = $this->user_model->user_password($username);
                                                                                    $this->load->helper('date');
                                                                                    $format = 'DATE_W3C';
                                                                                    $time = standard_date($format, time());
                                                                                    $ip = mysql_real_escape_string($this->input->ip_address());
                                                                                            $data = array(
                                                                                                    'username' => mysql_real_escape_string($username),
                                                                                                    'password' => mysql_real_escape_string($password),
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
                                                                                                            'privilege' => $result['privilege'],
                                                                                                            'school_contest' => $check_enroll1 ? $check_enroll1 :$check_enroll2
                                                                                                            );
                                                                                                    $this->session->set_userdata($newdata);
                                                                                                    //session_destroy();
                                                                                                    echo true;
                                                                                                    }
                                                                                        }

    			}
        }

        
}