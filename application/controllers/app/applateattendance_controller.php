<?php

class applateattendance_controller extends CI_Controller {

    public function LoadLateAttData() {
        //$postDataObj = json_decode($this->input->post('data'), TRUE);
        $postDataObj = json_decode('{"adm_no":"1241","access_key":"FG0P9OJECOQWLLMH2FSIZ0JHRS5S0AQ5GGKFUVKW80JJCWS529ES0O0H6VZXVFS2"}', TRUE);
        //print_r($postDataObj); exit;
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
             //print_r($dataObj); exit;
            $this->load->model('app/applateattendance_model', 'modelObj');
            $jsonLateResult = $this->modelObj->GetLateAttendance($dataObj);
            $jsonLateSummary = $this->modelObj->GetTardySummary($dataObj);
            if ($jsonLateSummary && $jsonLateResult) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('late_attendance' => $jsonLateResult, 'late_summary' => $jsonLateSummary));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        }else{
            echo printCustomMsg('ERRINPUT');
        }
//        echo json_encode(array('late_attendance' => $jsonLateResult, 'late_summary' => $jsonLateSummary));
    }

}
