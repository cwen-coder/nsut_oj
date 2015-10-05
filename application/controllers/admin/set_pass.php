<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author CWen Yin <[email address]>
* @date(2015-7-14)
*/ 
class Set_pass extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }
    
    public function index(){
        $data['contest'] = $this->user_model->school_info();
        //p($data);die;
        $this->load->view('admin/set_pass.html', $data);
    }
    //随机生成比赛密码
    public function set_pass_(){
        $data['contest_id'] = mysql_real_escape_string($this->input->post('contest_id'));
        $user = $this->user_model->get_user($data['contest_id']);
        foreach($user as $v):
            $data['pass'] = substr(md5($v['user_id'].rand(100000, 999999).$v['user_id']), 0, 15);
            $error[] = $this->user_model->set_pass($v['user_id'], $data);
        endforeach;
        if(in_array('fail', $error)){
            echo json_encode(array('code' => '-1', 'message' => '设置失败'));
        }else{
             echo json_encode(array('code' => '1', 'message' => '设置成功'));
        }
    }
    //导出比赛密码条
    public function upload_pass(){
        $this->load->library('phpexcel');
        //require_once 'PHPExcel/Writer/Excel2007.php';
        //require_once 'PHPExcel/Writer/Excel5.php';
        $contest_id = mysql_real_escape_string($this->uri->segment(4));
        $data = $this->user_model->get_team_pass($contest_id);
        $resultPHPExcel = new PHPExcel(); 
        //设置参数
            
        //设值 
        $resultPHPExcel->getActiveSheet()->setCellValue('A1', 'team号'); 
        $resultPHPExcel->getActiveSheet()->setCellValue('B1', '密码'); 
        $resultPHPExcel->getActiveSheet()->mergeCells('B1:C1');
        $i = 2; 
        foreach($data as $item):
        $a = 'B' . $i;
        $b = 'C' . $i;
        //合并单元格
        $resultPHPExcel->getActiveSheet()->mergeCells("$a:$b");
        $resultPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['team_id']); 
        $resultPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['team_pwd']); 
        $i ++; 
        endforeach;
        
        $outputFileName = '校赛密码条.xls'; 
        $xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel); 
        //ob_start(); ob_flush(); 
        header("Content-Type: application/force-download"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Type: application/download"); 
        header('Content-Disposition:inline;filename="'.$outputFileName.'"'); 
        header("Content-Transfer-Encoding: binary"); 
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Pragma: no-cache"); 
        $finalFileName = time().'.xls'; 
        $xlsWriter->save($finalFileName); 
        echo file_get_contents($finalFileName); 
        }
}