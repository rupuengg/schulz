<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class staffparentmessage_controller extends MY_Controller {

    public function index() {
        $this->load->view('staff/staffparentmessage/index.php');
    }

    public function GetTeacherSubjects() {
        $staff_id = $this->session->userdata('staff_id');
        $this->load->model('core/core', 'modelTempObj');
        $result_subject = $this->modelTempObj->getstaffsubjectlist($staff_id);
        try {
            echo json_encode(array("subjectList" => $result_subject));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetAllSections() {
        $this->load->model('core/core', 'SectionModelObj');
        $result_section = $this->SectionModelObj->getAllSection();
        try {
            echo json_encode(array("sectionList" => $result_section));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetAllSectionStudent() {
        $section_id = $this->input->post('section_id');
        $section_id = json_decode($section_id);
        $staff_id = $this->session->userdata('staff_id');
        if ($this->session->userdata('is_staff_classteacher') == 'YES') {
            $teacher_section_id = $this->session->userdata('staff_classteacher_section_id');
        }
        $this->load->model('core/core', 'modelObj');
        $result1 = $this->modelObj->getAllStudent($section_id);
        $result3 = $this->modelObj->getAllStudent($teacher_section_id);
        $this->load->model('staff/staffparentmessage_model', 'modelLenObj');
        for ($i = 0; $i < count($result3); $i++) {
            $result_length = $this->modelLenObj->GetConversationLength($staff_id, $result3[$i]['adm_no']);
            $result3[$i]['TotalSms'] = $result_length[0]['totalSms'];
        }
        for ($i = 0; $i < count($result1); $i++) {
            $result_length = $this->modelLenObj->GetConversationLength($staff_id, $result1[$i]['adm_no']);
            $result1[$i]['TotalSms'] = $result_length[0]['totalSms'];
        }
        try {
            echo json_encode(array("myStudentList" => $result1, "StudListTeacher" => $result3));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetStudentFromSubject() {
        $subject_id = $this->input->post('subject_id');
        $subject_id = json_decode($subject_id);
        $staff_id = $this->session->userdata('staff_id');
        $this->load->model('staff/staffparentmessage_model', 'modelTempObj');
        $result2 = $this->modelTempObj->GetStudNameFrmSubModel($subject_id);
        for ($i = 0; $i < count($result2); $i++) {
            $result_length = $this->modelTempObj->GetConversationLength($staff_id, $result2[$i]['adm_no']);
            $result2[$i]['TotalSms'] = $result_length[0]['totalSms'];
        }
        try {
            echo json_encode(array("myStudSubList" => $result2));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveSendMessage() {
        $staff_id = $this->session->userdata('staff_id');
        $adm_no = $this->input->post('adm_no');
        $adm_no = json_decode($adm_no);
        $myMessage = json_decode($this->input->post('data'), true);
        $this->load->model('staff/staffparentmessage_model', 'smsTempObj');
        $result_sms = $this->smsTempObj->SaveSendMessageModel($myMessage, $staff_id, $adm_no);
        if ($result_sms == true) {
            echo json_encode(array("mySmsTempDetails" => $result_sms));
        } else {
            echo printCustomMsg("TRUESAVEERR");
        }
    }

    public function GetSmsDetails() {
        $staff_id = $this->session->userdata('staff_id');
        $adm_no = $this->input->post('adm_no');
        $adm_no = json_decode($adm_no);
        $this->load->model('staff/staffparentmessage_model', 'smsTempObj');
        $result_SmsDetail = $this->smsTempObj->GetSmsDetailModel($staff_id, $adm_no);
        try {
            echo json_encode(array("mySmsDetails" => $result_SmsDetail));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function UpdateReadStatus() {
        $staff_id = $this->session->userdata('staff_id');
        $adm_no = $this->input->post('adm_no');
        $adm_no = json_decode($adm_no);
        $this->load->model('staff/staffparentmessage_model', 'UpObj');
        $result_status = $this->UpObj->UpdateStatusModel($staff_id, $adm_no);
        try {
            if($result_status){
                echo printCustomMsg('TRUEUPDATE');
            }else {
                echo printCustomMsg("TRUESAVEERR");
            }
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
