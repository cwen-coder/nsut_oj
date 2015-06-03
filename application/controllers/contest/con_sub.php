<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author SUTNB <[email address]>
* @copyright [2015.05.19]
*/
class Problem_submit extends Con_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('problemsubmit_model','ps');
	}
	public function index() {
		
	}
}
?>