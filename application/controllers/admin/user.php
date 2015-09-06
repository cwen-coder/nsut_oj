<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author niuben <[email address]>
* @date(2015-9-5)
*/
class User extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('acmer_model','acmer');
	}
        public function index(){
            $this->load->view('admin/user_list.html');
        }
}