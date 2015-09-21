<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-7-14)
*/ 
class Set_pass extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }
    
    public function index(){
        $data['contest'] = $this->user_model->school_info();
        //p($data);die;
        $this->load->view('admin/set_pass.html', $data);
    }
    //随机生成比赛密码
    public function set_pass_(){
        $data['contest_id'] = $this->input->post('contest_id');
        $user = $this->user_model->get_user($data['contest_id']);
        foreach($user as $v):
            $data['pass'] = md5($v['user_id'].rand(100000, 999999).$v['user_id']);
            $error[] = $this->user_model->set_pass($v['user_id'], $data);
        endforeach;
        if(in_array('fail', $error)){
            echo json_encode(array('code' => '-1', 'message' => '设置失败'));
        }else{
             echo json_encode(array('code' => '1', 'message' => '设置成功'));
        }
    }
    
}