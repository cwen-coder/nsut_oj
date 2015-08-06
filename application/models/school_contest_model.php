<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_contest_model extends CI_Model {
                    function __construct(){
                        parent::__construct();
                        require('db_info.inc.php');
                    }
              //校赛题目显示
              public function contest_pro($contest_id){
                                   $query = "SELECT problem_id,title,num,source FROM problem_contest 
		WHERE contest_id = '$contest_id'";
		$result = mysql_query($query);
		$data = array();
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$data[] = $row;
		}
		return $data;
              }
}
