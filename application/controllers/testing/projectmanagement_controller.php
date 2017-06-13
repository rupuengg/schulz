<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectmanagement_controller extends MY_Controller {

    public function AddProjects($project_id = -1) {
        $this->load->view('testing/projectmanagement.php', array("project_id" => $project_id));
    }

  
    public function TestingMain() {
        $this->load->view('testing/main.php');
    }

    public function DeveloperBugDetails($bug_id = -1) {
       $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->GetBugStatus($bug_id);
        $resultName = $this->ModelObj->GetDeveloperTesterName($bug_id);
        $resultRemark = $this->ModelObj->GetRemarkMessageModel($resultName['module_id']);
        $this->load->view('testing/developerbugdetail.php', array("bug_id" => $bug_id,"bug_details"=>isset($result)?$result:'',"remark_details"=>isset($resultRemark)?$resultRemark:'',"team_name"=>isset($resultName)?$resultName:''));
    }
    public function TesterBugDetails($bug_id = -1) {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->GetBugStatus($bug_id);
        $resultName = $this->ModelObj->GetDeveloperTesterName($bug_id);
        $resultRemark = $this->ModelObj->GetRemarkMessageModel($resultName['module_id']);
        $this->load->view('testing/testerbugdetail.php', array("bug_id" => $bug_id,"bug_details"=>isset($result)?$result:'',"remark_details"=>isset($resultRemark)?$resultRemark:'',"team_name"=>isset($resultName)?$resultName:''));
    }
    public function AdminBugDetails($projectId=-1,$moduleId=-1) {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $resultproject = $this->ModelObj->GetProject();
        $resultprojectmodule = $this->ModelObj->GetProjectModule($projectId);
        $this->load->view('testing/adminbugdetail.php',array("projectId"=>$projectId,"arrProject"=>$resultproject,"moduleId"=>$moduleId,"arrModule"=>$resultprojectmodule));
    }

    public function CompanyLoginDetail() {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->checkLoginDetail(json_decode($this->input->post('data'), true));
        if ($result == "TRUE") {
            echo printCustomMsg("TRUE", "Login Successfully", null);
        } else {
            echo printCustomMsg("FALSE", $result, null);
        }
    }

    public function UpdateBugStatusDeveloper() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->UpdateBugStatus_model($myArr);
        if ($result ==true) {
            echo printCustomMsg("TRUE",'YES', null);
        } else {
            echo printCustomMsg("FALSE","NO", null);
        }
    }
    public function UpdateBugStatusTester() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->UpdateBugStatusTester_model($myArr);
        if ($result ==true) {
            echo printCustomMsg("TRUE",'YES', null);
        } else {
            echo printCustomMsg("FALSE","NO", null);
        }
    }
   public function UpdateBugPendingStatusTester() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->UpdateBugPendingStatusTester_model($myArr);
        if ($result ==true) {
            echo printCustomMsg("TRUE",'YES', null);
        } else {
            echo printCustomMsg("FALSE","NO", null);
        }
    }
public function SaveRemarkMessage() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->SaveRemarkMessageModel($myArr);
        if($result==true){
            echo printCustomMsg("TRUE",'YES', null);
        }else{
            echo printCustomMsg("FALSE","NO", null);
        }
      
    }
}
