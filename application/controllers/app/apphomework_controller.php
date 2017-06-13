<?php

class apphomework_controller extends CI_Controller {

    public function LoadHomeworkData() {
        //$postDataObj = json_decode($this->input->post('data'), TRUE);
        $postDataObj = json_decode('{"adm_no":"1241","access_key":"FG0P9OJECOQWLLMH2FSIZ0JHRS5S0AQ5GGKFUVKW80JJCWS529ES0O0H6VZXVFS2"}', TRUE);

        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/apphomework_model', 'modelObj');
            $resultHomeworkJson = $this->modelObj->GetMyHomeworkData($dataObj);
             if ($resultHomeworkJson) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('homeworkData' => $resultHomeworkJson));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
//        $resultMyHomeworkJson = $this->modelObj->GetMyHomeworkDetail($dataObj, $homeworkId);
    }

    public function LoadMyHomeworkData() {
       // $postDataObj = json_decode($this->input->post('data'), TRUE);
        $postDataObj = json_decode('{"hw_id":"11","adm_no":"1241","access_key":"FG0P9OJECOQWLLMH2FSIZ0JHRS5S0AQ5GGKFUVKW80JJCWS529ES0O0H6VZXVFS2"}', TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/apphomework_model', 'modelObj');
            $resultMyHomeworkJson = $this->modelObj->GetMyHomeworkDetail($dataObj, $postDataObj['hw_id']);
            if ($resultMyHomeworkJson) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('myhomeworkData' => $resultMyHomeworkJson));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
