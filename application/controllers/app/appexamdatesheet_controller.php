<?php

class appexamdatesheet_controller extends CI_Controller {

    public function LoadMyExamDateSheet() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if(!empty($postDataObj)) { 
        $this->load->model('app/appparent_core', 'coreObj');
        $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
        $this->load->model('app/appexamdatesheet_model', 'modelObj');
        $exmdtsht = $this->modelObj->GetExamDateSheet($dataObj);
        if ($exmdtsht) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('examDateSheet' => $exmdtsht));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

    public function GetDateSheet() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if(!empty($postDataObj)) { 
        $this->load->model('app/appparent_core', 'coreObj');
        $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
        $this->load->model('app/appexamdatesheet_model', 'modelObj');
        $result = $this->modelObj->GetMyexamdateSheet($dataObj, $postDataObj['examId']);
        if ($result) {
                echo printCustomMsg('TRUE', 'Data Load successfully..',array('examDateSheetData' => $result));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
