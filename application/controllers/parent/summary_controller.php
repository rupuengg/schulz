<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class summary_controller extends MY_Controller {

    public function LoadSummary() {
        $this->load->view('parent/summary_view/summary.php');
    }

    public function GetALLSummaryDetails() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/summary_model', 'modelObj');
        $result = $this->modelObj->GetSummaryDetails($dataObj);
        echo json_encode($result);
    }

    public function GetCardCount() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/card_model', 'modelObj');
        $cardCount = $this->modelObj->GetCardCount($dataObj);
        echo json_encode($cardCount);
    }

    public function GetStudentmarks() {
       $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/summary_model', 'modelObj');
        $stumark = $this->modelObj->GetStuMarks($dataObj);
        echo json_encode($stumark);
    }

}
