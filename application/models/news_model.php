<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen <[email address]>
* @date(2015-10-20)
*/

class  News_model extends CI_Model {

	//const TBL_CATE = "users";

	function __construct(){
		parent::__construct();
		require('db_info.inc.php');
	}

	public function addNews($data) {
		$query = " SELECT * FROM news WHERE contest_id = '$data[contestId]' ";
		$result = mysql_query($query);
		if($result) {
			if(mysql_num_rows($result) == 0) {
				$queryAdd = "INSERT INTO news (contest_id, content) VALUES('$data[contestId]','$data[newContent]') ";
				return mysql_query($queryAdd);
			} else {
				$queryUpdate = "UPDATE news SET content = '$data[newContent]' WHERE contest_id = '$data[contestId]' " ;
				return mysql_query($queryAdd);
			}
		} else {
			return false;
		}
	}

	public function getNews($contestId) {
		$query = "SELECT content from news WHERE contest_id = '$contestId' ";
		$result = mysql_query($query);
		if($result) {
			return mysql_fetch_assoc($result)['content'];
		} else {
			return false;
		}
	}
}


?>