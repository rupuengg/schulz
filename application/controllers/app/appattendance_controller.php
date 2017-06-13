<?php

class appattendance_controller extends CI_Controller {

    public function LoadAttData() {
        //$postDataObj = json_decode($this->input->post('data'), TRUE);
                $postDataObj = json_decode('{"adm_no":"1241","access_key":"FG0P9OJECOQWLLMH2FSIZ0JHRS5S0AQ5GGKFUVKW80JJCWS529ES0O0H6VZXVFS2"}', TRUE);

        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appattendance_model', 'modelObj');
            $resultAttComplete = $this->modelObj->GetAbsentData($dataObj);
//            echo '<pre>';
//                print_r($resultAttComplete); exit;
            $resultAttSummary = $this->modelObj->GetSummary($dataObj);
            if($resultAttComplete && $resultAttSummary){
                echo printCustomMsg('TRUE', 'Data load succssfully', array('complete_attendance' => $resultAttComplete, 'complete_summary' => $resultAttSummary));
            }else {
                 echo printCustomMsg('ERRLOAD');
            }
            
//        echo json_encode(array('complete_attendance' => $resultAttComplete, 'complete_summary' => $resultAttSummary));
        }else{
            echo printCustomMsg('ERRINPUT');
        }
    }

}
