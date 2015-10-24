<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-5-19)
*/
class Problem_search extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('problem_model');
	}
	//后台按题号查找函数
	public function search_problem_byId() {
		$problem_id = $this->input->post('problem_id',TRUE);
		$result = preg_match("/^[0-9]*$/", $problem_id);
		if($result) {
			$problem = $this->problem_model->search_problem_byId($problem_id);
			if($problem == 0) {echo 1;return;}
		}else {
			echo false;
			return;
		}
		$problem = json_encode($problem);
		echo $problem;
		return;
	}

	//后台按标题查找函数
	public function search_problem_byTitle() {
		$title = $this->input->post('title',TRUE);
		$problem = $this->problem_model->search_problem_byTitle($title); 
		if($problem == 0) {
			echo false;
			return;
		} else {
			$problem = json_encode($problem);
			echo $problem;
			return;
		}
	}
	//后台按分类查找函数
	public function search_problem_byClass() {
		$class_name = $this->input->post('class_name',TRUE);
		$problem = $this->problem_model->search_problem_byClass($class_name);
		if($problem == 0) {
			echo false;
			return;
		} else {
			$problem = json_encode($problem);
			echo $problem;
			return;
		}
	}
}

?>