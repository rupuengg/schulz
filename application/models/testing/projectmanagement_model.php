<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectmanagement_model extends CI_Model {

    public function GetProject() {
        $this->load->database();
        $this->db->select('id,title');
        $projectDeatil = $this->db->get("test_project_details")->result_array();
        return $projectDeatil;
    }
    public function GetProjectModule($projectId) {
        $this->load->database();
        $this->db->select('id,title');
        $this->db->where('project_id',$projectId);
        $projectModuleDetail = $this->db->get("test_project_modules_details")->result_array();
        return $projectModuleDetail;
    }
    public function GetDeveloperTesterName($bug_id) {
        $this->load->database();
        $this->db->select('a.name,b.module_id');
        $this->db->from('company_staff_details a');
        $this->db->join('test_bug_details b','a.id=b.developer_id');
        $this->db->where('b.id',$bug_id);
        $arrDname = $this->db->get()->result_array();

        $this->load->database();
        $this->db->select('a.name,b.module_id');
        $this->db->from('company_staff_details a');
        $this->db->join('test_bug_details b','a.id=b.entry_by');
        $this->db->where('b.id',$bug_id);
        $arrTname = $this->db->get()->result_array();
        $arrFinalName=array("module_id"=>isset($arrDname[0]['module_id'])?$arrDname[0]['module_id']:'',"developer_name"=>isset($arrDname[0]['name'])?$arrDname[0]['name']:'',"tester_name"=>isset($arrTname[0]['name'])?$arrTname[0]['name']:'');
        return $arrFinalName;
    }

    public function UpdateBugStatus_model($myArr) {
         $this->load->database();
        if (isset($myArr['developer_comment'])) {
            $arrUpdateComment = array("developer_comment" => $myArr['developer_comment']);
            $this->db->where('id', $myArr['bug_id']);
            $this->db->update('test_bug_details', $arrUpdateComment);
        }
        $arrUpdateStatus = array("developer_status" => 'CHECKED');
        $this->db->where('id', $myArr['bug_id']);
        $this->db->update('test_bug_details', $arrUpdateStatus);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function GetBugStatus($bug_id) {
         $this->load->database();
        $this->db->select('a.id,b.title,a.developer_status,a.description,a.developer_comment,a.tester_comment,a.tester_status,a.entry_by');
        $this->db->from('test_bug_details a');
        $this->db->join('test_project_modules_details b', 'a.module_id = b.id');
        $this->db->where('a.id', $bug_id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function UpdateBugStatusTester_model($myArr) {
         $this->load->database();
        if (isset($myArr['tester_comment'])) {
            $arrUpdateComment = array("tester_comment" => $myArr['tester_comment']);
            $this->db->where('id', $myArr['bug_id']);
            $this->db->update('test_bug_details', $arrUpdateComment);
        }
        $arrUpdateStatus = array("developer_status" => 'DONE', "tester_status" => 'DONE');
        $this->db->where('id', $myArr['bug_id']);
        $this->db->update('test_bug_details', $arrUpdateStatus);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateBugPendingStatusTester_model($myArr) {
         $this->load->database();
        if (isset($myArr['tester_comment'])) {
            $arrUpdateComment = array("tester_comment" => $myArr['tester_comment']);
            $this->db->where('id', $myArr['bug_id']);
            $this->db->update('test_bug_details', $arrUpdateComment);
        }
        $arrUpdateStatus = array("developer_status" => 'PENDING', "tester_status" => 'PENDING');
        $this->db->where('id', $myArr['bug_id']);
        $this->db->update('test_bug_details', $arrUpdateStatus);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function SaveRemarkMessageModel($myArr) {
         $this->load->database();
         if($myArr['remark_from']=='TESTER'){
             $arrRemark=array("module_id"=>$myArr['module_id'],"remarks"=>$myArr['remark'],"screenshot_path"=>'',"remarks_from"=>$myArr['remark_from'],"entry_by"=>$myArr['developer_id']);
             $this->db->insert('test_bugs_remarks',$arrRemark);
             if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
             
         }else{
           $arrRemark=array("module_id"=>$myArr['module_id'],"remarks"=>$myArr['remark'],"screenshot_path"=>'',"remarks_from"=>$myArr['remark_from'],"entry_by"=>$myArr['developer_id']);
           $this->db->insert('test_bugs_remarks',$arrRemark); 
              if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
         }
             
        
    }
    public function GetRemarkMessageModel($module_id) {
         $this->load->database();
         $company_staff_id=$this->session->userdata('company_staff_id');
        $this->db->select("remarks,screenshot_path,remarks_from,timestamp,DATE_FORMAT(timestamp,'%H-%S') as time_timestamp",false);
        $this->db->where('module_id',$module_id);
        $this->db->order_by('timestamp','desc');
        $remarkDetail = $this->db->get("test_bugs_remarks")->result_array();
        return $remarkDetail;
           
    }

}
