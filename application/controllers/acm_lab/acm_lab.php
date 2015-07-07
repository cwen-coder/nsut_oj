<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acm_lab extends Admin_Controller {
/*Session_start();
if($_SESSION['privilege'] == 1) {
	$con = mysql_connect("localhost","root","yin123") or die("数据库连接除错！".mysql_error());
	if(mysql_select_db("jol",$con)) {
		echo "连接成功";
	} else {
		echo ('连接失败'.mysql_error());
	}
} else {
	echo "hdhfhdh";
	echo $_SESSION['privilege'];
	var_dump($_SESSION);
}*/
	function __construct() {
		parent::__construct();
		$this->load->model('acm_lab_model','acm_lab');
	}

	function index() {
		//$data['session'] = $this->session->userdata('item');
		//$this->load->view('admin/index.html');
		//echo "djhhjddddddddddddd";
		//ignore_user_abort();
		//set_time_limit(0);
		//while (true) {
			# code...
			$this->benchmark->mark('code_start');
			
			$acmer = $this->acm_lab->all_acmer_info();
			//p($acmer);
			$old_solved = array();
			$new_solved = array();
			$hdoj_url = array();
			$poj_url = array();
			$cf_url = array();
			//p($acmer);
			$all_new_solved = array();
			foreach ($acmer as $key => $value) {
				$old_solved[$key]['hdoj_solved'] = $acmer[$key]['hdoj_solved'];
				$old_solved[$key]['poj_solved'] = $acmer[$key]['poj_solved'];
				$old_solved[$key]['cf_rating'] = $acmer[$key]['cf_rating'];
				$old_solved[$key]['sutoj_solved'] = $acmer[$key]['sutoj_solved'];
				//self::hdoj($value['hdoj_name']);
				//$new_solved[$key]['hdoj_solved'] = self::hdoj($value['hdoj_name']);
				//$new_solved[$key]['poj_solved'] = self::poj($value['poj_name']);
				//$new_solved[$key]['cf_rating'] = self::cf($value['cf_rating']);
				$hdoj_url[$key] = "http://acm.hdu.edu.cn/userstatus.php?user=".$value['hdoj_name'];
				$poj_url[$key] = "http://poj.org/userstatus?user_id=".$value['poj_name'];
				$cf_url[$key] = "http://codeforces.com/profile/".$value['cf_name'];
				$all_poj_name[$key] = $value['poj_name'];
				$sut_name = $value['name'];
			}
			$new_solved['hdoj'] = self::hdoj($hdoj_url);
			$new_solved['poj'] = self::poj($poj_url,$all_poj_name);
			$new_solved['cf'] = self::cf($cf_url);
			$new_solved['sutoj'] = self::sutoj($sut_name);
			$count = count($new_solved['hdoj']);
			for($i = 0; $i < $ount; $i++) {
				$all_new_solved[$i]['hdoj_solved'] = $new_solved['hdoj'][$i];
				$all_new_solved[$i]['poj_solved'] = $new_solved['poj'][$i];
				$all_new_solved[$i]['cf_rating'] = $new_solved['cf'][$i];
				$all_new_solved[$i]['sutoj_solved'] = $new_solved['sutoj'][$i];
			}
			foreach ($acmer as $k => $value) {
				$last_time = $this->acm_lab->update_solved($all_new_solved[$k],$value[$k]['id']);
				if($last_time != false) {
					$cha_time = (time()-strtotime($last_time)) / 3600;
					$all_cha = ($all_new_solved[$k]['hdoj_solved']-$old_solved[$k]['hdoj_solved']) + ($all_new_solved[$k]['poj_solved']-$old_solved[$k]['poj_solved']) + ($all_new_solved[$k]['sutoj_solved']-$old_solved[$k]['sutoj_solved']);
					if($cha_time < 24) {
						$result = $this->acm_lab->update_one_solved($all_cha,$value[$k]['id']);
					} else {
						
					}
					
				}
			}

			//break;
			//p($old_solved);
			//p($new_solved);
			
			$this->benchmark->mark('code_end');
			echo $this->benchmark->elapsed_time('code_start', 'code_end');
		//}
				
	}

	private function hdoj($query_arr) {
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://acm.hdu.edu.cn/userstatus.php?user=".$hdoj_name);
		curl_setopt($ch, CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出
		$result=curl_exec($ch);
		curl_close($ch);
		//echo $result;
		preg_match('/<td>Problems Solved<\/td><td align=center>(.*?)<\/td>/i', $result,$info);
		//echo "jfdojofjd";
		//var_dump($info);
		//p($info);
		//echo "\n";
		if(!empty($info))
			return $info[1];
		else return 0;*/
		$ch = curl_multi_init(); 
		$count = count($query_arr); 
		$ch_arr = array(); 
		for ($i = 0; $i < $count; $i++) { 
			$query_string = $query_arr[$i]; 
			$ch_arr[$i] = curl_init($query_string);
			curl_setopt($ch_arr[$i], CURLOPT_HEADER ,0);    
			curl_setopt($ch_arr[$i], CURLOPT_RETURNTRANSFER, true); 
			curl_multi_add_handle($ch, $ch_arr[$i]); 
		} 
		$running = null; 
		do { 
			curl_multi_exec($ch, $running); 
		} while ($running > 0); 
		for ($i = 0; $i < $count; $i++) { 
			$results[$i] = curl_multi_getcontent($ch_arr[$i]); 
			preg_match('/<td>Problems Solved<\/td><td align=center>(.*?)<\/td>/i', $results[$i],$info);
			if(!empty($info))
				$results[$i] = $info[1];
			else $results[$i] = 0;
			curl_multi_remove_handle($ch, $ch_arr[$i]); 
		} 
		curl_multi_close($ch); 
		return $results; 

	}

	private function poj($query_arr,$all_poj_name) {
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://poj.org/userstatus?user_id=".$poj_name);
		curl_setopt($ch, CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出
		$result=curl_exec($ch);
		curl_close($ch);
		//echo $result;
		preg_match('/<a href=status\?result=0&user_id='.$poj_name.'>(.*?)<\/a>/i', $result,$info);
		//echo "jfdojofjd";
		//var_dump($info);
		//p($info);
		//echo "\n";
		if(!empty($info))
			return $info[1];
		else return 0;*/
		$ch = curl_multi_init(); 
		$count = count($query_arr); 
		$ch_arr = array(); 
		for ($i = 0; $i < $count; $i++) { 
			$query_string = $query_arr[$i]; 
			$ch_arr[$i] = curl_init($query_string);
			curl_setopt($ch_arr[$i], CURLOPT_HEADER ,0);    
			curl_setopt($ch_arr[$i], CURLOPT_RETURNTRANSFER, true); 
			curl_multi_add_handle($ch, $ch_arr[$i]); 
		} 
		$running = null; 
		do { 
			curl_multi_exec($ch, $running); 
		} while ($running > 0); 
		for ($i = 0; $i < $count; $i++) { 
			$results[$i] = curl_multi_getcontent($ch_arr[$i]); 
			preg_match('/<a href=status\?result=0&user_id='.$all_poj_name[$i].'>(.*?)<\/a>/i', $results[$i],$info);
			if(!empty($info))
				$results[$i] = $info[1];
			else $results[$i] = 0;
			curl_multi_remove_handle($ch, $ch_arr[$i]); 
		} 
		curl_multi_close($ch); 
		return $results; 

	}
	
	private function cf($query_arr) {
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://codeforces.com/profile/".$cf_name);
		curl_setopt($ch, CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出
		$result=curl_exec($ch);
		curl_close($ch);
		//echo $result;
		preg_match('/<span style=\"font-weight:bold;\" class=\"(.*?)\">(.*?)<\/span>/i', $result,$info);
		//echo "jfdojofjd";
		//var_dump($info);
		//p($info);
		//echo "\n";
		if(!empty($info))
			return $info[2];
		else return 0;*/
		$ch = curl_multi_init(); 
		$count = count($query_arr); 
		$ch_arr = array(); 
		for ($i = 0; $i < $count; $i++) { 
			$query_string = $query_arr[$i]; 
			$ch_arr[$i] = curl_init($query_string);
			curl_setopt($ch_arr[$i], CURLOPT_HEADER ,0);    
			curl_setopt($ch_arr[$i], CURLOPT_RETURNTRANSFER, true); 
			curl_multi_add_handle($ch, $ch_arr[$i]); 
		} 
		$running = null; 
		do { 
			curl_multi_exec($ch, $running); 
		} while ($running > 0); 
		for ($i = 0; $i < $count; $i++) { 
			$results[$i] = curl_multi_getcontent($ch_arr[$i]); 
			preg_match('/<span style=\"font-weight:bold;\" class=\"(.*?)\">(.*?)<\/span>/i', $results[$i],$info);
			if(!empty($info))
				$results[$i] = $info[2];
			else $results[$i] = 0;
			curl_multi_remove_handle($ch, $ch_arr[$i]); 
		} 
		curl_multi_close($ch); 
		return $results; 

	}

	private function sutoj($sut_name) {
		foreach ($sutname as $key => $value) {
			# code...
			$result[$key] = $this->acm_lab->get_sutoj_solved($value);
		}
		return $result;

	}
}

?>