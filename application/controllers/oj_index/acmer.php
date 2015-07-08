<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Cwen_Yin <[email address]>
* @copyright [2015.07.08]
*/
class Acmer extends Oj_Controller{

	function __construct(){
        parent::__construct();
        $this->load->model('acmer_model','acmer');
    }


	public function index() {
		if($this->session->userdata('username') && $this->session->userdata('user_id')) {
			$data['username'] = $this->session->userdata('username');
			$data['user_id'] = $this->session->userdata('user_id');
		}else {			
			$data['username'] = false;
			$data['user_id'] = false;
		}
		$acmer = $this->acmer->get_all_acmer();
		foreach ($acmer as $k => $v) {
			# code...
			$acmer[$k]['sum_10'] = $this->acmer->get_acmer_sum10($v['id']);
		}
		$data['acmer'] = $acmer;
		$this->load->view('oj_index/acmer.html',$data);

	}

}

?>