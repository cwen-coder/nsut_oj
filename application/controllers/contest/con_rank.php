<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.06.4]
*/
class Con_rank extends Con_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['contest_id'] = $this->uri->segment(4);
		$this->load->view('contest/con_rank.html',$data);
	}
}
?>