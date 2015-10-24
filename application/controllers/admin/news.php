<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen <[email address]>
* @date(2015-10-20)
*/
class News extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('news_model','news');
	}

	public function index() {
		$this->load->view("admin/news.html");
	}

	public function addNews() {
		$contestId = $this->input->post("contestId",TRUE);
		$newContent = $this->input->post("newContent",TRUE);
		$checkId = self::checkDigit($contestId);
		$clean = array();
		if($checkId != "合法") {
			error( "输入的比赛ID".$checkId);
		} else {
			$clean["contestId"] = mysql_real_escape_string($contestId);
		}
		$checkNew = self::checkText($newContent);
		if($checkNew != "合法") {
			error( "比赛新闻".$checkNew);
		} else {
			$clean["newContent"] = mysql_real_escape_string($newContent);
		}
		$result = $this->news->addNews($clean);
		if($result) {
			success('admin/news/index','成功');
		} else {
			error("失败");
		}
 
	}

	private function checkDigit($data) {
		if(empty($data)){
			return "不能空";
		}else if(!ctype_digit($data)) {
			return "类型不合法";
		}else if($data < 0 || $data >= 99999) {
			return "数值不在范围内";
		}
		return "合法";
	}

	private function checkText($data) {
		if(empty($data)){
			return "不能空";

		} else if(strlen($data) > 500) {

			return "内容过长";
		}
		return "合法";
	}

} 


?>