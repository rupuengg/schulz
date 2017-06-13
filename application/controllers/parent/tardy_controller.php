<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tardy_controller extends MY_Controller {

    public function LoadTardy() {
        $this->load->view('parent/tardy_view/tardy.php');
    }

    public function GetLateAttendance() {
       $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/tardy_model', 'modelObj');
        $trady_result = $this->modelObj->GetLateAttendance($dataObj);
        echo json_encode($trady_result);
    }

    public function GetTardyStatus() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/tardy_model', 'modelObj');
        $tardy_result = $this->modelObj->GetTardySummary($dataObj);
        echo json_encode($tardy_result);
    }

}