<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Volunteer_Controller{

	function __construct() {
		parent::__construct();
		$this->load->model('volunteer_model','volunteer');
	}
	 #ÔØÈëÖ¾Ô¸ÕßËÍÇòÒ³Ãæ
	function index() {
		//$data['session'] = $this->session->userdata('item');
		$start = $this->session->userdata('start');
		$end = $this->session->userdata('end');
		$no_balloon = $this->volunteer->get_no_balloon();
		$r_balloon =  $this->volunteer->get_r_balloon();
		//p($r_balloon);
		$data['no_balloon'] = array();
		$data['r_balloon'] = array();
		$count = 0;
		foreach ($no_balloon as $key => $value) {
			//p( $value);
			$team_id = substr($value['team_id'],4,10);
			if($team_id >= $start && $team_id <= $end ) {
				$data['no_balloon'][$count]['solution_id'] = $value['solution_id'];
				$data['no_balloon'][$count]['team_id'] = $value['team_id'];
				$data['no_balloon'][$count]['num'] = $value['solution_id'];
				$data['no_balloon'][$count]['color'] = $this->volunteer->get_balloon($value['num']+1)['color'];
				$count++;
			}
		}

		$count1 = 0;
		foreach ($r_balloon as $key => $value) {
			//p($value);
			$team_id = substr($value['team_id'],4,10);
			if($team_id >= $start && $team_id <= $end ) {
				$data['r_balloon'][$count1]['solution_id'] = $value['solution_id'];
				$data['r_balloon'][$count1]['team_id'] = $value['team_id'];
				$data['r_balloon'][$count1]['num'] = $value['solution_id'];
				$data['r_balloon'][$count1]['color'] = $this->volunteer->get_balloon($value['num']+1)['color'];
				$count1++;
			}
		}
		$this->load->view('volunteer/index.html',$data);		
	}

	public function song_require() {
		$solution_id = $this->input->post('solution_id',TRUE);
		p($solution_id);
		$result = $this->volunteer->song_require($solution_id);
		if($result == true) {
			redirect('volunteer/home/index');
		} else {
			error("ËÍÇòÊ§°Ü£¡");
		}
	}

	public function song_require_back() {
		$solution_id = $this->input->post('solution_id',TRUE);
		p($solution_id);
		$result = $this->volunteer->song_require_back($solution_id);
		if($result == true) {
			redirect('volunteer/home/index');
		} else {
			error("³·ÏúÊ§°Ü£¡");
		}
	}

}
