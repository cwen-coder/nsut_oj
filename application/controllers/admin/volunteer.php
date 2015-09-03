<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author CWen Yin <[email address]>
* @date(2015-8-31)
*/

class Volunteer extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('volunteer_model','volunteer');
	}

	public function index() {
		$data['volunteer'] = $this->volunteer->get_all_volunteer();
		$this->load->view('admin/volunteer.html',$data);
	}

	public function volunteer_add() {
		$this->load->library('encrypt');
		$data['name'] = $this->input->post('volunteer_name',TRUE);
		$data['pwd'] =  $this->encrypt->encode($this->input->post('volunteer_pwd',TRUE));
		$data['start'] = $this->input->post('start',TRUE);
		$data['end'] = $this->input->post('end',TRUE);
		//p($data);
		$result = $this->volunteer->volunteer_add($data);
		if($result == true) {
			success('admin/volunteer','添加成功');
		} else {
			error("添加失败");
		}
	}

	public function volunteer_del() {
		$id = $this->input->post('id',TRUE);
		$result = $this->volunteer->volunteer_del($id);
		echo $result;
	}

	public function get_volunteer() {
		$id = $this->input->post('id');
		$result = $this->volunteer->get_volunteer($id);
		if($result == false) echo false;
		else echo json_encode($result);
	}

	public function volunteer_edit() {
		$id = $this->input->post('hide_id',TRUE);
		$start = $this->input->post('start',TRUE);
		$end = $this->input->post('end',TRUE);
		//p($start);die;
		$result = $this->volunteer->volunteer_edit($id,$start,$end);
		if($result == true) {
			success('admin/volunteer','修改成功');
		} else {
			error("修改失败");
		}
	}

	public function volunteer_edit_pwd() {
		$this->load->library('encrypt');
		$id = $this->input->post('id',TRUE);
		//p($id);
		$pwd = $this->encrypt->encode($this->input->post('new_pwd',TRUE));
		//p($pwd);
		$result = $this->volunteer->volunteer_edit_pwd($id,$pwd);
		//echo $result;
		if($result == true) {
			success('admin/volunteer','修改成功');
		} else {
			error("修改失败");
		}
	}
}

?>