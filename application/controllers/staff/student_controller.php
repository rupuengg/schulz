<?php

require_once (APPPATH . 'core/Barcode39.php');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class student_controller extends MY_Controller {

    //put your code here
    public function newAdmission() {

        $this->load->model('staff/student_model', 'objStudentProfile');
        $admno = $this->objStudentProfile->getNewAdmNo();
        $admno = $admno['adm_no'] + 1;
        $this->load->view("staff/student_view/newadmission", array("admno" => $admno));
    }

    public function loadStudentView($admno = NULL) {
        if ($admno == NULL) {
            $this->load->model('staff/student_model', 'objStudentProfile');
            $admno = $this->objStudentProfile->getNewAdmNo();
            $admno = $admno['adm_no'] + 1;
            $type = "NEW";
        } else {
            $type = "UPDATE";
        }
        $myArray = array("admno" => $admno, "type" => $type);
        try {
            $this->load->view("staff/student_view/profile", $myArray);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getStudentProfile() {
        $adm_no = $this->input->post('data');
        $this->load->model('staff/student_model', 'objStudentProfile');
        $biodata = $this->objStudentProfile->getStudentBioData($this->input->post('data'));
        $relation = $this->objStudentProfile->getStudentRelations($this->input->post('data'));
        $medical = $this->objStudentProfile->getStudentMedical($this->input->post('data'));
        $output = array();
        $output['basicdata'] = $biodata;
        $output['relations'] = $relation;
        $output['medical'] = $medical;
//        print_r($output['basicdata']);exit;
        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function saveNewAdmission() {
        try {
            $this->load->model('staff/student_model', 'objStudentProfile');
            if ($this->objStudentProfile->saveNewAdmission($this->input->post('data'))) {
                echo '{"status":"TRUE","message":"Saved successfully"}';
            } else {
                echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
            }
        } catch (Exception $exc) {
            echo '{"status":"ERROR","message":"' . $exc->getMessage() . '"}';
        }
    }

    public function saveUpdateStundentDetail() {
        try {
            $this->load->model('staff/student_model', 'objStudentProfile');
            if ($this->objStudentProfile->saveProfileData($this->input->post('data'), $this->input->post('type'), $this->input->post('school'), $this->input->post('sessionyear'))) {
                echo '{"status":"TRUE","message":"Saved successfully"}';
            } else {
                echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
            }
        } catch (Exception $exc) {
            echo '{"status":"ERROR","message":"' . $exc->getMessage() . '"}';
        }
    }

    /*     * *********** Adarsh Module- Student Profile   ************** */

    public function loadStudentProfilePage($admno = NULL) {
        if ($admno == '') {
            echo 'Wrong Page';
        } else {
            $this->load->view("staff/student_view/studentprofile_view", array("admno" => $admno));
        }
    }

    public function getStudentDetails() {
        $adm_no = $this->input->post('data');
        $this->load->model('staff/student_model', 'objStudentbiodata');
        $biodata = $this->objStudentbiodata->getStudentBioData($adm_no);
        $relation = $this->objStudentbiodata->getStudentRelations($adm_no);
        $medical = $this->objStudentbiodata->getStudentMedical($adm_no);
        $bluecard = $this->objStudentbiodata->getStudentBlueCards($adm_no);
        $section = $this->objStudentbiodata->getStudentClassDetails($adm_no);
        $subject = $this->objStudentbiodata->getSubjectTeacher($adm_no);
        $absent = $this->objStudentbiodata->getStudentAbsentDetails($adm_no);
        $late = $this->objStudentbiodata->getStudentLateDetails($adm_no);
        $cards = $this->objStudentbiodata->getAllCards($adm_no);
        $output = array();
        $output['biodata'] = $biodata;
        $output['card'] = $bluecard;
        $output['All'] = $cards;
        $output['section'] = $section;
        $output['subject'] = $subject;
        $output['relation'] = $relation;
        $output['medical'] = $medical;
        $output['absent'] = $absent;
        $output['late'] = $late;
        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function issueCards() {
        $this->load->model('staff/student_model', 'objIssucards');
        $cards = $this->objIssucards->issuecards();
        if ($cards) {
            echo printCustomMsg("TRUE", "Cards Succesfuuly Issued", $cards);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        };
    }

    public function GetStudentPhoto($adm_no, $type = "THUMB") {
        if ($adm_no) {
            $this->load->model('staff/student_model', 'modelObj');
            $photoPath = $this->modelObj->getStudentPhoto($adm_no, $type);
//            print_r($photoPath);exit;
            if (!file_exists($photoPath)) {
                $photoPath = DPHOTOPATH;
                $this->output
                        ->set_content_type(@end(explode(".", $photoPath))) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
                        ->set_output(file_get_contents($photoPath));
            } else {
                $this->output
                        ->set_content_type(@end(explode(".", $photoPath))) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
                        ->set_output(file_get_contents($photoPath));
            }
        }
    }

    /*     * ***************************** Student Section Assign Module Function ************************************ */

    public function StudentSectionAssign($class = -1) {
        $this->load->model('core/core', 'dbobj');
        $sectionList = $this->dbobj->GetAllSection();
        $this->load->view('staff/student_view/studentsectionassign_view', array("class" => $class, "sectionList" => $sectionList));
    }

    public function profilePictureUpload() {
        $dbObj = json_decode($this->input->post('data'), true);
        $encodedImageData = str_replace(' ', '+', $dbObj['image']);
        $encodedImageData = str_replace('data:image/png;base64,', '', $dbObj['image']);
        $decodedImageData = base64_decode($encodedImageData);
        $uploadDirPath = 'uploads/' . $dbObj['adm_no'] . '/';
        $filePath = 'uploads/' . $dbObj['adm_no'] . '/' . time() . $dbObj['adm_no'] . '.png';
        if (!is_dir($uploadDirPath)) {
            mkdir($uploadDirPath, 0755, TRUE);
        }
        if (file_put_contents($filePath, $decodedImageData)) {
            echo printCustomMsg('UPLOAD', 'Image upload successfully.', $filePath);
        } else {
            echo printCustomMsg('UPLOADERROR', 'Image not upload successfully.', -1);
        }
    }

    //******************************Student id cards***********************//  Sapna


    public function loadIdcardview($sec_id = NULL, $adm_no = NULL) {
        $this->load->model('core/core', 'dbobj');
        $section_list = $this->dbobj->getSectionlist();
        $this->load->model('staff/student_model', 'modelobj');
        $idcardinfo = $this->modelobj->idCardDetails($sec_id, $adm_no);
        $adm = array_column($idcardinfo, "adm_no");
//        print_r($adm);exit;
        foreach ($adm as $key => $value) {
            $this->barcodegenerator($value);
        }
        try {
            $this->load->view("staff/student_view/idcard_view", array('section_id' => $sec_id, "section_list" => $section_list, 'idcardinfo' => $idcardinfo));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function barcodegenerator($adm) {
//        echo $adm;exit;
        $path = 'files/idcards/';
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        $barObj = new Barcode39("$adm");
        $barObj->barcode_text_size = 4;
        $barObj->barcode_bar_thick = 3;
        $barObj->barcode_bar_thin = 2;
        $barObj->draw($path . $adm . '.gif');
//
    }

    /*     * **********************studentsummary(sapna)*********************************** */

    public function getStudSummaryView($sec_id = NULL) {
        $this->load->model('core/core', 'dbobj');
        $section_list = $this->dbobj->getSectionlist();
        $this->load->model('staff/student_model', 'model');
        $classTeacher = $this->model->getclassTeacher($sec_id);
        $this->load->view("staff/student_view/studentsummary_view", array('classteacher' => $classTeacher, 'section_id' => $sec_id, "section_list" => $section_list,));
    }

    public function GetStudentsummaryDetail() {
        $dataObj = json_decode($this->input->post('data'), true);
        $this->load->model('staff/student_model', 'model');
        $studsummary = $this->model->GetStudentsummaryDetail($dataObj['admno']);
        try {
            echo json_encode($studsummary);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
