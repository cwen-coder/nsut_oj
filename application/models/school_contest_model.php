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
              //排名信息
              public function school_con_rank($contest_id){
                  $query = "SELECT
                                users.user_id,users.username,solution.result,solution.num,solution.in_date
                                        FROM
                                                (select * from solution where solution.contest_id='$contest_id' and num>=0 ) solution
                                        left join users
                                        on users.user_id=solution.user_id
                                ORDER BY users.user_id,in_date";
                  $result = mysql_query($query);
                  $data = array();
                  while ($row = mysql_fetch_array($result,MYSQL_ASSOC))
			$data[] = $row;
                 mysql_free_result($result);
                 return $data;
              }
}
