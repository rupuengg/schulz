<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class academics_controller extends MY_Controller {

    public function LoadAcademics() {
        $this->load->view('parent/academics_view/academics.php');
    }

    public function LoadMarks() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/academics_model', 'modelObj');
        $stuMarks = $this->modelObj->LoadStudentMarks($dataObj);
        echo json_encode($stuMarks);
    }

    public function GetGraphDataDetail() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/academics_model', 'modelObj');
        $stuMarks = $this->modelObj->GetGraphData($dataObj);
        echo json_encode($stuMarks);
    }

}
