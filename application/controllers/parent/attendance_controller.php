<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class attendance_controller extends MY_Controller {

    public function LoadAttendance() {
        $this->load->view('parent/attendance_view/attendance.php');
    }

    public function AttAbsentData() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/attendance_model', 'modelObj');
        $result = $this->modelObj->GetAbsentData($dataObj);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode($result);
        }
    }

    public function AttSummary() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/attendance_model', 'modelObj');
        $result = $this->modelObj->GetSummary($dataObj);
        echo json_encode($result);
    }

}
