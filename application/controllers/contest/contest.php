<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends Sch_Controller{
    function __construct() {
        parent::__construct(); 
        $this->load->model('school_contest_model','sch_model');
        $this->load->model('oj_con_model','oj_con');
        $this->load->model('contest_model');
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
                          $data['contest'] = $this->oj_con->con_byId($data['contest_id']);
                          //$data['pro'] = $this->sch_model->contest_pro($data['contest_id']);                  
                          $con_pro_id = $this->contest_model->get_con_pro_id($data['contest_id']);
                          $con_pro_sub = $this->oj_con->get_con_pro_sub($data['user_id'], $data['contest_id']);
                          $con_pro_ac = $this->oj_con->get_con_pro_ac($data['user_id'], $data['contest_id']);
                         $data['pro'] = array();
		foreach ($con_pro_id as $v) {
			$data['pro'][$v['num']] = $v;
			foreach ($con_pro_sub as $sub) {
				if($v['problem_id'] == $sub['problem_id']) {
					$temp = 0;
					foreach ($con_pro_ac as $ac) {
						if($v['problem_id'] == $ac['problem_id']) {
							$data['pro'][$v['num']]['status'] = true;
							$temp = 1;
							break;
						} 
					}
					if($temp == 0) {
						$data['pro'][$v['num']]['status'] = false;
					}
				}
			}
		}
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                          //p($con_pro_id);p($con_pro_sub);p($con_pro_ac);die;
                          $this->load->view('contest/sch_pro_list.html',$data);
            }
        }
        //提交状态显示
        public function status(){
             if(($a=$this->session->userdata('school_contest')) && ($b=$this->session->userdata('username')) && ($c=$this->session->userdata('user_id')) ){
                                                    $data['contest_id'] =$a;
                                                    $data['username'] =  $b;                                              
			$data['user_id'] = $c;
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
            if(isset($data['contest_id'] )){
                                   $data['contest'] = $this->oj_con->con_byId($data['contest_id']);
		$limit=0;
		if($data['pagination'] = $this->input->get('pagination')) 
			$limit = $data['pagination']*20-20;
		if($this->input->get('previous')) 
			$data['previous'] = $this->input->get('previous');
		$num=20;
		$sum = $this->oj_con->con_problem_status_sum($data['contest_id']);
		//p($sum['count(*)']);
		if($data['pagination'] != 0 && $data['pagination']*20 < $sum['count(*)']) {
			$data['pag'] = true;
		}else if($data['pagination'] == 0 && $sum['count(*)'] > 20) {
			$data['pag'] = true;
		}
		$data['pagination'] = $limit/20+2;
		$data['judge_result']=Array("Pending", "Pending Rejudging", "Compiling", "Running & Judging", "Accepted", "Presentation Error", "Wrong Answer", "Time Limit Exceed", "Memory Limit Exceed", "Output Limit Exceed", "Runtime Error", "Compile Error", "Compile OK","Test Running Done");
		$data['judge_color']=Array("btn_status gray","btn_status btn-info","btn_status btn-warning","btn_status btn-warning","btn_status btn-success","btn_status btn-danger","btn_status btn-danger","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-warning","btn_status btn-info");
		$data['result'] = $this->oj_con->con_problem_status($data['contest_id'],$limit, $num);
		//p($data);
		$count = count($data['result']);
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		for ($i = 0; $i < $count; $i++) {
			$result = $this->oj_con->get_username($data['result'][$i]['user_id']);
			$data['result'][$i]['username'] = $result['username'];
		}
                        $this->load->view('contest/sch_con_status.html',$data);
            }
        }
        //载入比赛题目
        public function con_pro() {
             if(($a=$this->session->userdata('school_contest')) && ($b=$this->session->userdata('username')) && ($c=$this->session->userdata('user_id')) ){
                                                    $data['contest_id'] =$a;
                                                    $data['username'] =  $b;                                              
			$data['user_id'] = $c;
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
            if(isset($data['contest_id'] )){
		$contest_id = $this->uri->segment(4);
		$problem_id = $this->uri->segment(5);
		$num = $this->uri->segment(6);
		$data['pro'] = $this->oj_con->con_pro_byId($problem_id);
		$data['num'] = $num;
		$data['contest_id'] = $contest_id;
                                   $data['contest'] = $this->oj_con->con_byId($data['contest_id']);
		//echo "jdfkdjfkdfjkj";
		//p($data);
		$this->load->view('contest/sch_con_pro.html',$data);
                }
        }
        //载入提交页
        public function sch_pro_sub() {
             if(($a=$this->session->userdata('school_contest')) && ($b=$this->session->userdata('username')) && ($c=$this->session->userdata('user_id')) ){
                                                    $data['contest_id'] =$a;
                                                    $data['username'] =  $b;                                              
			$data['user_id'] = $c;
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
            if(isset($data['contest_id'] )){
		$data['contest_id'] = $this->uri->segment(4);
		$data['problem_id'] = $this->uri->segment(5);
		$data['num'] = $this->uri->segment(6);
                                   $data['contest'] = $this->oj_con->con_byId($data['contest_id']);
                                   if (time() < strtotime($data['contest']['start_time'])) {
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('对不起比赛还未开始 ');history.go(-1); </script>";
		} else if(time() > strtotime($data['contest']['end_time'])){
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('对不起比赛已经结束 ');history.go(-1); </script>";
		}else {
			$this->load->view('contest/sch_submit.html',$data);
		}
	}
        }
        //校赛提交动作
        public function sch_submit() {
                                    if(($a=$this->session->userdata('school_contest')) && ($b=$this->session->userdata('username')) && ($c=$this->session->userdata('user_id')) ){
                                                    $data['contest_id'] =$a;
                                                    $data['username'] =  $b;                                              
			$data['user_id'] = $c;
                                     }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
                                     }
            if(isset($data['contest_id'] )){
		$data['cid'] = $this->input->post('cid', TRUE);
		$contest = $this->oj_con->con_byId($data['cid']);
                                   if (time() < strtotime($contest['start_time'])) {
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('对不起比赛还未开始 ');history.go(-1); </script>";
		} else if(time() > strtotime($contest['end_time'])){
			header('Content-Type:text/html;charset=utf-8');
                                                    echo "<script type='text/javascript'> alert('对不起比赛已经结束 ');history.go(-1); </script>";
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
        //校赛现场排名
        public function rank(){
            if(($a=$this->session->userdata('school_contest')) && ($b=$this->session->userdata('username')) && ($c=$this->session->userdata('user_id')) ){
                                                    $data['contest_id'] =$a;
                                                    $data['username'] =  $b;                                              
			$data['user_id'] = $c;
            }else{
                                                    $data['username'] = false;
			$data['user_id'] = false;
            }
            if(isset($data['contest_id'] )){
               function sec2str($sec){
	return sprintf("%02d:%02d:%02d",$sec/3600,$sec%3600/60,$sec%60);
               }
               $rank = array();
               $data['rank'] = array();
               $user_cnt = -1;
               $user_name = ' ';
                $rank = $this->sch_model->school_con_rank($data['contest_id']);
                $data['contest'] = $this->oj_con->con_byId($data['contest_id']);
                foreach($rank as $v):
                    if($user_name != $v['user_id']){
                        $user_cnt++;
                        $data['rank'][$user_cnt]['user_id'] = $v['user_id'];
                        $data['rank'][$user_cnt]['username'] = $v['username'];                   
                        $user_name = $v['user_id'];
                        $data['rank'][$user_cnt]['solved'] = 0;
                        $data['rank'][$user_cnt]['time'] = 0;
                    }
                    //$rank_info = $v;
                    if (isset($data['rank'][$user_cnt]['p_ac_sec'][$v['num']]) && $data['rank'][$user_cnt]['p_ac_sec'][$v['num']]>0)
                                break;
                         if (intval($v['result']) !=4){
                                if(isset($data['rank'][$user_cnt]['p_wa_num'][$v['num']])){
                                        $data['rank'][$user_cnt]['p_wa_num'][$v['num']]++;
                                }else{
                                        $data['rank'][$user_cnt]['p_wa_num'][$v['num']]=1;
                                 }
                        }else{
                                $data['rank'][$user_cnt]['p_ac_sec'][$v['num']] = sec2str(strtotime($v['in_date']) - strtotime($data['contest']['start_time']));
                                $data['rank'][$user_cnt]['solved']++;
                                if(!isset($data['rank'][$user_cnt]['p_wa_num'][$v['num']])) $data['rank'][$user_cnt]['p_wa_num'][$v['num']]=0;
                                $data['rank'][$user_cnt]['time'] += (strtotime($v['in_date']) - strtotime($data['contest']['start_time'])) +$data['rank'][$user_cnt]['p_wa_num'][$v['num']]*1200;
                        }
                 endforeach;
                 foreach ($data['rank'] as $key => $row){
                        $solved[$key]  = $row['solved'];
                        $time[$key] = $row['time'];
                    }
                 array_multisort($solved, SORT_DESC, $time, SORT_ASC, $data['rank']);
                //p($data);die;
                $this->load->view('contest/sch_con_rank.html',$data);
            }
        }
}