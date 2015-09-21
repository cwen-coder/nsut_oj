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
    public function set_pass(){
        $contest_id = $this->input->post('contest_id');
        
    }
    
}