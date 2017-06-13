<?php

class examdatesheet_controller extends MY_Controller {

    public function LoadExamDateSheetView($examId = -1) {
        $this->load->model('parent/examdatesheet_model', 'modelObj');
        $dateSheetResult = $this->modelObj->GetMyexamdateSheet($examId);
        $this->load->view('parent/examdatesheet_view/examdatesheet_view', array("examDateSheet" => $dateSheetResult));
    }

    public function GetDateSheet() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/examdatesheet_model', 'modelObj');
        $result = $this->modelObj->GetExamDateSheet($dataObj);
        echo json_encode($result);
    }

}
