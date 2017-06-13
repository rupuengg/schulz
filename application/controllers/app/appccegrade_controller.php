<?php

class appccegrade_controller extends CI_Controller {

    public function LoadCceGradeData($term = 1) {
        //$postDataObj = json_decode($this->input->post('data'), TRUE);
        $postDataObj = json_decode('{"adm_no":"1241","access_key":"FG0P9OJECOQWLLMH2FSIZ0JHRS5S0AQ5GGKFUVKW80JJCWS529ES0O0H6VZXVFS2"}', TRUE);

        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appccegrade_model', 'modelObj');
            $jsonCceResult = $this->modelObj->GetCCEGradeDetails($dataObj);
            $termCceDeatil = $this->modelObj->RightCCEGrade($dataObj, $term);
            if ($termCceDeatil && $jsonCceResult) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('gradeDeatil' => $jsonCceResult, 'termDetail' => $termCceDeatil));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
