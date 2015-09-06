<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-8-31)
*/

class Balloon extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('volunteer_model','volunteer');
	}

	public function index() {
		$data['balloon'] = $this->volunteer->get_all_balloon();
		$data['arr'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
		$this->load->view('admin/balloon.html',$data);
	}

	public function balloon_add() {
		$num = $this->input->post('num',TRUE);
		$color = $this->input->post('color',TRUE);
		//p($num);
		//$num =  - 64;
		/*if($num >= 1 && $num <= 26) {

		} else {
			error("添加失败");
		}*/
		//p($num);
		$len = strlen($color);
		//p($len);
		$num = self::checkNum($num);
		if($num == false || $len != 3) {
			error_link('admin/balloon',"添加失败！");
		} else {
			$result = $this->volunteer->balloon_add($num,$color);
			if($result != true) {
				error_link('admin/balloon',"添加失败！");
			} else {
				success('admin/balloon',"添加成功！");
			}
		}
	}

	private function checkNum($num) {
		$arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
		foreach ($arr as $key => $value) {
			if($num == $value) {
				$n = $key +1;
				break;
			}
		}
		if(isset($n)) {
			return $n;
		} else {
			return false;
		}
	}

	public function balloon_del() {
		$id = $this->input->post('id',TRUE);
		$result = $this->volunteer->balloon_del($id);
		echo $result;
	}

	public function balloon_edit() {
		$num = $this->input->post('hide_num',TRUE);
		$color = $this->input->post('color',TRUE);
		$len = strlen($color);
		//p($num);
		//p($len);
		//$num = self::checkNum($num);
		//p($num);
		//p($color);
		//die;
		if($num == false || $len != 3) {
			error_link('admin/balloon',"修改失败！");
		} else {
			$result = $this->volunteer->balloon_edit($num,$color);
			if($result != true) {
				error_link('admin/balloon',"修改失败！");
			} else {
				success('admin/balloon',"修改成功！");
			}
		}
	}

	public function get_balloon() {
		$id = $this->input->post('id');
		$result = $this->volunteer->get_balloon($id);
		if($result == false) echo false;
		else echo json_encode($result);
	}
}

?>