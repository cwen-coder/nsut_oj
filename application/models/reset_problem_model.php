<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-7-14)
*/
class Reset_problem_model extends CI_Model {
	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}
}
?>