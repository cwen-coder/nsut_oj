<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-9-4)
*/

class Contest_res extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('contest_model');
	}

	public function index() {
		$data['contest'] = $this->contest_model->get_all_con();
		//$data['contest'] = json_encode($data['contest']);
		$data['now'] = date('Y-m-d H:i:s',time());
		//p($data);
		
		$this->load->view('admin/contest_res.html',$data);
	}

}

?>