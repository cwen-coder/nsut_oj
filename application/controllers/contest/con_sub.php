<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.05.19]
*/
class Con_sub extends Con_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('oj_con_model','oj_con');
		//$this->load->model('problemsubmit_model','ps');
	}

	public function index() {
		$data['user_id'] = $this->session->userdata('user_id');
		$data['cid'] = $this->input->post('cid', TRUE);
		$contest = $this->oj_con->con_byId($data['cid']);
		if(!$data['user_id']){
			$offset = $this->uri->segment(5);
		 	redirect('oj_index/home/contest_list/'.$offset.'/1000');
		 	//echo 1;
		} else if($contest['con_class'] == 2 && (!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $contest['con_pwd'])) {
				$offset = $this->uri->segment(5);
				//echo 2;
				redirect('oj_index/home/contest_list/'.$offset.'/1001/'.$contest_id);
		} else if (time() < strtotime($contest['start_time'])) {
			//echo 3;
				redirect('contest/home/index/'.$data['contest_id']);
		} else if(time() > strtotime($contest['end_time'])){
			//echo 4;
			error("对不起比赛已经结束！您无法提交!");
		}else {
			//echo 5;
			$data['source'] = $this->input->post('source', TRUE);
			$data['language'] = $this->input->post('language', TRUE);
			$data['pid'] = $this->input->post('pid', TRUE);
			$data['ip'] = $this->session->userdata('ip_address');
			$data['code_length'] = strlen($data['source']);
			/*echo $data['code_length'];die;*/
			if(!empty($data['source'])) {
				//echo 6;
				$check_pro = $this->oj_con->check_pro($data['pid']);
				$check_con = $this->oj_con->check_con($data['cid']);
				$check_con_pro = $this->oj_con->check_con_pro($data['pid'],$data['cid']);
				if($check_pro && $check_con && $check_con_pro) {
					$data['num'] = $check_con_pro['num'];
					//echo 7;
					$result = $this->oj_con->problem_submit($data);
					$url = 'oj_index/home/status';
					if($result) {
						//echo 11;
						success($url,'提交成功');
					}else {
						error("提交失败！");
					}
				} else {
					//echo 8;
					error("提交的比赛或是题目不存在！");
				}
			}else {
				//echo 9;
				error("代码长度太短！");
			}
		}
	}
}
?>