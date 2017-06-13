<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ccegrade_controller extends MY_Controller {

    public function LoadCCEGrade() {
        $this->load->view('parent/ccegrades_view/ccegrades.php');
    }

    public function GetCCEGrade() {
      $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/ccegrade_model', 'modelObj');
        $result = $this->modelObj->GetCCEGradeDetails($dataObj);
        echo json_encode($result);
    }

    public function GetRightCCEGrade() {
        $term=  json_decode($this->input->post('data'));
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/ccegrade_model', 'modelObj');
        $result = $this->modelObj->RightCCEGrade($dataObj,$term);
        echo json_encode($result);
    }

}
