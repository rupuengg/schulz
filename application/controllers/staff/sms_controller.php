<?php

class Sms_Controller extends MY_Controller {

    public function index() {
        $this->load->view('staff/sms/sms_view.php');
    }

    public function SendSms() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        if (!$dataObj) {
            echo "Data Not parse..";
        } else {
            $this->load->model('staff/sms_model', 'smsModelObj');
            $result = $this->smsModelObj->SmsDetails($dataObj);
            try {
                if ($result > 0) {
                    echo printCustomMsg("TRUE", "SMS Send successfully", $result);
                } else {
                    echo printCustomMsg("SAVEERR", "SMS not Send successfully", $result);
                }
            } catch (Exception $exe) {
                echo printCustomMsg('ERR', NULL, $exe->getMessage());
            }
        }
    }

    public function GetAllSection() {
        $this->load->model('core/core', 'codeModelObj');
        $sectionlist = $this->codeModelObj->GetAllSection();
        try {
            echo json_encode(array("section" => $sectionlist));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetAllStudent($section_id = 'ALL') {
        $this->load->model('core/core', 'modelObj');
        $result = $this->modelObj->GetAllStudent($section_id);
        try {
            echo json_encode(array("student_list" => $result));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
