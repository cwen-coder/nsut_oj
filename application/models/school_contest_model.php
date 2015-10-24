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
                                solution.user_id,teams.team_name,teams.team_id,solution.result,solution.num,solution.in_date
                                        FROM
                                                (select * from solution where solution.contest_id='$contest_id' and num>=0 ) solution,teams
                                        where teams.user_id=solution.user_id  and teams.contest_id='$contest_id' 
                                ORDER BY teams.user_id,in_date";
                  $result = mysql_query($query);
                  $data = array();
                  while ($row = mysql_fetch_array($result,MYSQL_ASSOC))
			$data[] = $row;
                 mysql_free_result($result);
                 return $data;
              }
}
