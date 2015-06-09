<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.06.10]
*/
class Ask_pro extends Con_Controller {
	function __construct() {
		parent::__construct();
	}

	//载入比赛提问页面
	public function index() {
		$data['contest_id'] = $this->uri->segment(4);
		$this->load->view('contest/ask_pro.html',$data);
	}
}
?>