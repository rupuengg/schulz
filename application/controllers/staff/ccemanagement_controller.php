<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ccemanagement_controller extends MY_Controller {

    public function managecce($class = '-1') {
        $this->load->model('core/core', 'dbobj');
        $classList = $this->dbobj->getClassList('YES');
        $this->load->view('staff/cce_view/manageccelist', array("class" => $class, "myclassarr" => $classList));
    }

    public function managecee_teacher($section_id = '-1') {
        $this->load->model('core/core', 'dbobj');
        $section_list = $this->dbobj->getSectionlist('YES');
        $this->load->model('core/cce', 'dbobjcce');
        if ($section_id == -1) {
            
        } else {
            $this->dbobjcce->fillCCETeacherMasterData($section_id);
        }
        $this->load->view('staff/cce_view/cceteacherassign', array("section_id" => $section_id, "section_list" => $section_list));
    }

    //modules/function by Amit to rupani
    public function ccegradeentryload() {
        $this->load->view('staff/cce_view/gradeentry.php');
    }

    public function GradeSummaryView() {
        $this->load->view('staff/cce_view/ccegradesummary.php');
    }

    public function GetCceName() {
        $this->load->model('core/cce', 'modelObj');
        $staff_id = $this->session->userdata('staff_id');
        $cceGradeName = $this->modelObj->GetAllCceSubjectName($staff_id);
        try {
            echo json_encode(array("ccegradename" => $cceGradeName));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetMyStudent() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $dataNew = json_decode($dataObj->detail);
        $this->load->model('core/cce', 'mymodelObj');
        $result = $this->mymodelObj->GetAllStudent($dataObj);
        $classTeacher = $this->mymodelObj->GetClassTeacherName($dataNew->section_id);
        $this->load->model('core/cce', 'gradeObj');
        $gradeList = $this->gradeObj->GetAllCceGrade($dataObj);
        try {
            echo json_encode(array("nameList" => $result, "gradeList" => $gradeList, "classTeacher" => $classTeacher));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveGradeDetail() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('core/cce', 'saveModelObj');
        $mySaveResult = $this->saveModelObj->SaveGradeDetails($dataObj);
        if ($mySaveResult) {
            echo printCustomMsg("TRUE", "Grade Save Successfully", null);
        } else {
            echo printCustomMsg("SAVEERR", "Grade not Save successfully", null);
        }
    }

    public function GetGradeDetails() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('core/cce', 'modelObj');
        $classTeacher = $this->modelObj->GetClassTeacherName($dataObj->section_id);
        $cceStudentList = $this->modelObj->GetCceStudentList($dataObj);
        try {
            echo json_encode(array("cceStudentList" => $cceStudentList, "classTeacher" => $classTeacher['class_teacher'], 'classteacherid' => $classTeacher['teachr_id']));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetAllSection() {
        $this->load->model('core/cce', 'modelObj');
        $sectionlist = $this->modelObj->GetAllCceSection();
        try {
            echo json_encode(array("section" => $sectionlist));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
