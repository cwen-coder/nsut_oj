<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-9-4)
*/

class Contest_res extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('contest_model');
	}

	public function index() {
		$data['contest'] = $this->contest_model->get_all_con();
		//$data['contest'] = json_encode($data['contest']);
		$data['now'] = date('Y-m-d H:i:s',time());
		//p($data);
		

		$this->load->view('admin/contest_res.html',$data);
	}

	public function contest_sim() {
		$contest_id = $this->uri->segment(4);
		//p($contest_id);
		$sim = $this->contest_model->get_sim($contest_id);
		$con_class = $this->contest_model->get_con_class($contest_id);
		$arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		//p($sim);
		$data['sim'] = array();
		if($con_class == 3 || $con_class == 4) {
			foreach ($sim as $key => $v) {
				$team = $this->contest_model->get_sim_team_id($v['s_id']);
				$team_s = $this->contest_model->get_sim_team_id($v['sim_s_id']);
				$data['sim'][$key]['user_id'] = $team['team_id'];
				$data['sim'][$key]['source'] = $team['source_code'];
				$data['sim'][$key]['user_s_id'] = $team_s['team_id'];
				$data['sim'][$key]['s_source'] = $team_s['source_code'];	
				$data['sim'][$key]['sim'] = $v['sim'];	
				$data['sim'][$key]['num'] = $arr[$v['num']];
				
			}
		} else {
			foreach ($sim as $key => $v) {
				//$data['sim'][$key][]
				$user = $this->contest_model->get_sim_user_id($v['s_id']);
				$user_s = $this->contest_model->get_sim_user_id($v['sim_s_id']);
				$data['sim'][$key]['user_id'] = $user['user_id'];
				$data['sim'][$key]['source'] = $user['source_code'];
				$data['sim'][$key]['user_s_id'] = $user_s['user_id'];
				$data['sim'][$key]['s_source'] = $user_s['source_code'];	
				$data['sim'][$key]['sim'] = $v['sim'];	
				$data['sim'][$key]['num'] = $arr[$v['num']];
			}
		}

		//p($data);
		$this->load->view('admin/contest_sim.html',$data);
	}

}

?>