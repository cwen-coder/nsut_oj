<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Cwen Yin <[email address]>
* @copyright [2015.05.29]
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

		//后期修改damin权限问题
		
		$privilege = $this->session->userdata('privilege');
		if(!$data['user_id']){
			$offset = $this->uri->segment(5);
		 	redirect('oj_index/home/contest_list/'.$offset.'/1000');
		 	//echo 1;
		} else if($contest['con_class'] == 2 && (!$this->session->userdata('con_pwd') || $this->session->userdata('con_pwd') != $contest['con_pwd']) && $privilege != 1) {
				$offset = $this->uri->segment(5);
				//echo 2;
				redirect('oj_index/home/contest_list/'.$offset.'/1001/'.$contest_id);
		} else if (time() < strtotime($contest['start_time']) && $privilege != 1) {
			//echo 3;
				redirect('contest/home/index/'.$data['contest_id']);
		} else if(time() > strtotime($contest['end_time']) && $privilege != 1){
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
					$data['source'] = base64_decode($data['source']);
				if(get_magic_quotes_gpc()){
				$data['source']=stripslashes($data['source']);//删除由 addslashes() 函数添加的反斜杠
			}
			$data['source'] = mysql_real_escape_string($data['source']);//转义 SQL 语句中使用的字符串中的特殊字符
					$result = $this->oj_con->problem_submit($data);
					$url = 'contest/home/status';
					if($result) {
						//echo 11;
						redirect('contest/home/con_status/'.$data['cid']);
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
