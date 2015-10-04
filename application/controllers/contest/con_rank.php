<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Cwen Yin<[email address]>
* @copyright [2015.06.4]
*/
class Con_rank extends Con_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('rank_model');
		$this->load->model('oj_con_model','oj_con');
	}

	public function index() {
		$data['contest_id'] = $this->uri->segment(4);
		$con_user = $this->rank_model->get_user_byContest($data['contest_id']);
		$contest = $this->oj_con->con_byId($data['contest_id']);
		if($this->session->userdata('privilege') != 1) {
			if($contest['con_class'] == 2 && (!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $contest['con_pwd'])) {
					$offset = $this->uri->segment(5);
					//echo 2;
					redirect('oj_index/home/contest_list/'.$offset.'/1001/'.$contest_id);
			}else if (time() < strtotime($contest['start_time'])) {
					redirect('contest/home/index/'.$data['contest_id']);
			}
		}
		$count = count($con_user);
		for ($i = 0; $i < $count; $i++) {
			$result = $this->oj_con->get_username($con_user[$i]['user_id']);
			$con_user[$i]['username'] = $result['username'];
		}
		$con_pro = $this->rank_model->get_con_byContest($data['contest_id']);
		foreach ($con_user as  $key => $vu) {
			$con_user[$key]['ac_sum'] = 0;
			$con_user[$key]['error_sum'] = 0;
			//$con_user[$key]['penalty'] 
			$time_penalty = 0;
			foreach ($con_pro as $vp) {
				$sub_error = $this->rank_model->get_con_pro_info($data['contest_id'],$vu['user_id'],$vp['num']);
				$sub_ac = $this->rank_model->get_con_pro_ac($data['contest_id'],$vu['user_id'],$vp['num']);
				$con_user[$key][$vp['num']]['error_sum'] = $sub_error['count(*)'];
				$con_user[$key][$vp['num']]['ac_time'] = $sub_ac['in_date'];
				//$con_user[$key]['error_sum'] += $sub_error['count(*)'];
				if($sub_ac['in_date'] != NULL) {
					$error_after_ac = $this->rank_model->error_after_ac($data['contest_id'],$vu['user_id'],$vp['num'],$sub_ac['in_date']);
					$con_user[$key][$vp['num']]['error_sum'] = $sub_error['count(*)'] - $error_after_ac['count(*)'];
					$con_user[$key]['ac_sum']++;
					$time_penalty += strtotime($sub_ac['in_date']) - strtotime($contest['start_time']);	
					//$time_penalty += $con_user[$key]['error_sum']*20*60;
					$con_user[$key]['error_sum'] += $con_user[$key][$vp['num']]['error_sum'];

					$ac_time = strtotime($sub_ac['in_date']) - strtotime($contest['start_time']);	
					$seconds = floor($ac_time % 60);
					$minutes = floor(($ac_time / 60) % 60);
					$hours = floor($ac_time / 3600);
					if($seconds < 10 && $seconds > 0)$seconds = '0'.$seconds;			
					if($minutes < 10 && $minutes > 0)$minutes = '0'.$minutes;		
					if($hours < 10 && $hours > 0)$hours = '0'.$hours;
					$con_user[$key][$vp['num']]['ac_time'] = $hours.':'.$minutes.':'.$seconds;	
				}
			}
			$time_penalty += $con_user[$key]['error_sum']*20*60;
			//p($time_penalty);
			if($time_penalty < 0) {
				$con_user[$key]['penalty'] = "00:00:00";
			} else {
				$seconds = floor($time_penalty % 60);
				$minutes = floor(($time_penalty / 60) % 60);
				$hours = floor($time_penalty / 3600);
				if($seconds < 10)$seconds = '0'.$seconds;			
				if($minutes < 10)$minutes = '0'.$minutes;		
				if($hours < 10)$hours = '0'.$hours;
				$con_user[$key]['penalty'] = $hours.':'.$minutes.':'.$seconds;
			}
		}

		foreach ($con_user as $key => $row) {
    		$ac_sum[$key]  = $row['ac_sum'];
   	 		$penalty[$key] = $row['penalty'];
		}
		if($count > 0)
			array_multisort($ac_sum, SORT_DESC, $penalty, SORT_ASC, $con_user);
		//p($con_user);die;
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$data['con_user'] = $con_user;
		$data['con_pro'] = $con_pro;
		$this->load->view('contest/con_rank.html',$data);

	}
}
?>