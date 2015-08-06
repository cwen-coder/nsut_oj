<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends Sch_Controller{
    function __construct() {
        parent::__construct(); 
        $this->load->model('school_contest_model');
    }
    
    //载入校赛题目页
        public function school_pro_list(){
            if(($a=$this->session->userdata('school_contest')) && ($b=$this->session->userdata('username')) && ($c=$this->session->userdata('user_id')) ){
                                                    $data['contest_id'] =$a;
                                                    $data['username'] =  $b;                                                   
			$data['user_id'] = $c;
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
            if(isset($data['contest_id'] )){
                        // $this->school_contest->contest_pro($data);
                         $this->load->view('contest/school_pro_list.html',$data);
            }
        }
}