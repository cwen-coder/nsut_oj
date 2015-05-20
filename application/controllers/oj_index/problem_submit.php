<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.05.19]
*/
class Problem_submit extends Oj_Controller{
	function __construct(){
		parent::__construct();
		//$this->load->model('problemsubmit','ps');
	}
	function index(){
		//$this->input->post('source');
		echo "11111";
		$session_id = $this->session->userdata('ip_address');
		echo "<br/>";
		echo $session_id;
	}
}