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
    /*public function index() {
        echo "sidhfi";
    }*/
    public function username_check() {
        $username = mysql_real_escape_string($this->input->post('username',TRUE));
        $result = $this->user_model->check_username($username);
        //$this->output->enable_profiler(TRUE);
        if($result > 0)
            echo false;
        else
            echo true;
    }
    //获取ajax传回数据验证是否存在
    public function email_check() {
        $email = mysql_real_escape_string($this->input->post('email',TRUE));
        $result = $this->user_model->check_email($email);
        if($result > 0)
            echo false;
        else
            echo true;
    }
    //获取ajax传回数据验证是否存在
    public function teamname_check(){
        $user_id = $this->session->userdata('user_id');
        $teamname = mysql_real_escape_string($this->input->post('teamname',TRUE));
        $contest_id = mysql_real_escape_string($this->input->post('contest_id',TRUE));
        $result = $this->user_model->teamname_check($teamname, $contest_id, $user_id);
        if($result > 0)
            echo false;
        else
            echo true;
    }
    //报名 完善信息
    public function enroll(){
        $captcha = mysql_real_escape_string($this->input->post('cap_r', TRUE));
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
                    'rules' => 'required | max_length[32] | xss_clean '
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
            $time = standard_date($format, time());
            $contest_id = $this->input->post('contest_id',TRUE);
            $username = $this->input->post('username',TRUE);
            $usernum = $this->input->post('usernnum',TRUE);
            $user1name = $this->input->post('user1name',TRUE);
            $user1num = $this->input->post('user1num',TRUE);
            $user2name = $this->input->post('user2name',TRUE);
            $user2num = $this->input->post('user2num',TRUE);
            $teamname = $this->input->post('teamname',TRUE);
            $phone = $this->input->post('phone',TRUE);
            $user_id = $this->session->userdata('user_id');
            if($this->user_model->teamname_check($teamname, $contest_id, $user_id) > 0 || !isset($user_id) || !$this->user_model->check_enroll($user_id, $contest_id)  ){
                    echo false;
            }  else {              
                $team_id = $this->user_model->check_num_team($contest_id)+1;
                $data = array(
                        'user_id' => mysql_real_escape_string($user_id),
                        'contest_id' => mysql_real_escape_string($contest_id),
                        'team_name' => mysql_real_escape_string($teamname),
                        'team_num1' => mysql_real_escape_string($usernum),
                        'team_name1' => mysql_real_escape_string($username),
                        'team_num2' => mysql_real_escape_string($user1num),
                        'team_name2' => mysql_real_escape_string($user1name),
                        'team_num3' => mysql_real_escape_string($user2num),
                        'team_name3' => mysql_real_escape_string($user2name),
                        'enroll_time' => $time,
                        'team_id' => 'team'.$team_id,
                        'phone' => mysql_real_escape_string($phone)
                    );
                //echo $data;
                //$result = true;
                $result = $this->user_model->enroll($data);
                if($result)
                    echo true;
                else
                    echo  false;
            }
    }
}
    //注册
    public function reg_act() {
        //$this->output->enable_profiler(TRUE);
        $captcha = $this->input->post('cap_r',TRUE);
        if (strtolower($captcha) !=  strtolower($_SESSION ['code'])) {
            echo 2;
            //echo 2;
            return;
        } 
        //$this->load->helper('form');
        $this->load->library('form_validation');
        $config = array(
                array(
                'field' => 'username',
                'label' => '用户名',
                //'rules' =>'required'
                'rules' => 'required | min_length[6] | max_length[32] | alpha_numeric | xss_clean '
                ),
                array(
                'field' => 'password1',
                'label' => '密码',
                // 'rules' =>'required'
                'rules' => 'required  | min_length[6] | max_length[32] | xss_clean'
                ),
                array(
                'field' => 'password2',
                'label' => '确认密码',
                //'rules' =>'required'
                'rules' => 'required  | min_length[6] | max_length[32] | xss_clean'
                ),
                array(
                'field' => 'email',
                'label' => '邮箱',
                // 'rules' =>'required'
                'rules' => 'required | valid_email | xss_clean '
                )
            );
        $this->form_validation->set_rules($config);
        $status = $this->form_validation->run();
        if($status == false ) {
            echo false;
        }else {
            $this->load->library('encrypt');
            $this->load->helper('date');
            $format = 'DATE_W3C';
            $time = standard_date($format, time());
            $username = $this->input->post('username',TRUE);
            $password1 = $this->input->post('password1',TRUE);
            $password2 = $this->input->post('password2',TRUE);
            $email = $this->input->post('email',TRUE);
            $ip = $this->input->ip_address();
            if ($this->user_model->check_username($username) > 0 || $password1 != $password2 || $this->user_model->check_email($email) > 0 )
                echo  false;
            else {
                //$user_id = md5($username.mt_rand(100,999));
                $data = array(
                        'user_id' => mysql_real_escape_string($username),
                        'username' => mysql_real_escape_string($username),
                        'password' => mysql_real_escape_string($this->encrypt->encode($password1)),
                        'accesstime' => $time,
                        'reg_time' => $time,
                        'ip' =>  $ip,
                        'email' => mysql_real_escape_string($email)
                    );
                $result = $this->user_model->reg_act($data);
                if($result)
                    echo true;
                else
                    echo  false;
            }
        }
        
    }
}