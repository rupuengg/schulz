<?php

class appsummary_controller extends CI_Controller {

    public function LoadSummaryData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appsummary_model', 'modelObj');
            $this->load->model('app/appcard_model', 'cardObj');
            $arrCard = $this->cardObj->GetCardCount($dataObj);
            $summaryData = $this->modelObj->GetSummaryDetails($dataObj);
            $marksSummaryData = $this->modelObj->GetStuMarks($dataObj);
            if ($marksSummaryData && $summaryData && $arrCard) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('summaryData' => $summaryData, 'cardCount' => $arrCard['cardcount'], 'studentCard' => $arrCard['studentName'], 'marksSummaryData' => $marksSummaryData));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
//        echo json_encode(array('summaryData' => $summaryData, 'cardCount' => $arrCard['cardcount'], 'studentCard' => $arrCard['studentName'], 'marksSummaryData' => $marksSummaryData));
    }

//    public function LoadStudentMarksData() {
//        $postDataObj = json_decode($this->input->post('data'), TRUE);
//        $this->load->model('app/appparent_core', 'coreObj');
//        $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
//        $this->load->model('app/appsummary_model', 'modelObj');
//        $this->load->model('app/appcard_model', 'cardObj');
//        $marksSummaryData = $this->modelObj->GetStuMarks($dataObj);
//        echo json_encode(array('marksSummaryData' => $marksSummaryData));
//    }
}
