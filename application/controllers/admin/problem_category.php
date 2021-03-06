<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_category extends  Admin_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('Problemcategory_model','cate');
		$this->load->helper('url');
	}
	//载入首页
	function index(){
		//$this->config->set_item('url_suffix', '');
		$total_rows = $this->cate->total_rows();
		$config['base_url'] = site_url('admin/problem_category/index');   
		$config['total_rows'] = $total_rows;//记录总数，这个没什么好说的了，就是你从数据库取得记录总数   
		$config['per_page'] = 10; //每页条数。额，这个也没什么好说的。。自己设定。默认为10好像。   
		$config['first_link'] = '首页'; // 第一页显示   
		$config['last_link'] = '末页'; // 最后一页显示   
		$config['next_link'] = '下一页 >'; // 下一页显示
		$config['prev_link'] = '< 上一页'; // 上一页显示   
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li><a style="color:white;background-color:blue">'; // 当前页开始样式   
		$config['cur_tag_close'] = '</a></li>'; 
        		$config['num_links'] = 4;//    当前连接前后显示页码个数。意思就是说你当前页是第5页，那么你可以看到3、4、5、6、7页。   
        		$config['uri_segment'] = 4; 
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$data['offset'] = $this->uri->segment(4);
		if($data['offset'] == null) $data['offset']=0;
		$data['category'] = $this->cate->check($config['per_page'], $data['offset'] );
		$this->load->view('admin/problem_category.html', $data);
	}
	//添加题目类别
	function add_category(){
		$problem_category = $this->input->post('problem_category',TRUE);
		$result = $this->cate->add($problem_category);
		$url = 'admin/problem_category/index';
		if($result){
			success($url,'添加成功');
       		 }else{
       		 	error('添加失败');
        		}
	}
	//删除题目类别
	function delete_category(){
		$cid = $this->input->post('cid',TRUE);
		$result = $this->cate->delete($cid);
		$url = 'admin/problem_category/index';
		if($result){
			success($url,'删除成功');
       		 }else{
       		 	error('删除失败');
        		}
    	}
    	//修改题目类别
	function edit_category(){
		$cid = $this->input->post('cid',TRUE);
		$category =$this->input->post('problem_category');
		$result = $this->cate->edit_category($cid, $category);
		$url = 'admin/problem_category/index';
		if($result){
			success($url,'修改成功');
       		 }else{
       		 	error('修改失败');
        		}
	}
}
?>
