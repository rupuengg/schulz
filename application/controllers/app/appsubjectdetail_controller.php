<?php

class appsubjectdetail_controller extends CI_Controller {

    public function subjectdata() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
//$postDataObj = json_decode('{"adm_no":"7046","subject_id":"55","access_key":"OADFXVR582ZR7YKV5F2YAERZ3IPY1GRFHVK3F1ZEUOVRB5C7A4VB8C02LFQDL7IU"}', TRUE);
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appsubjectdetail_model', 'modelObj');
            $stuSubject = $this->modelObj->subjectDetail($dataObj, $postDataObj['subject_id']);
            if ($stuSubject) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('subject_detail' => $stuSubject));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

    public function markstructure() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            //$postDataObj = json_decode('{"adm_no":"7046","exam_id":"91","access_key":"OADFXVR582ZR7YKV5F2YAERZ3IPY1GRFHVK3F1ZEUOVRB5C7A4VB8C02LFQDL7IU"}', TRUE);
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appsubjectdetail_model', 'modelObj');
            $result = $this->modelObj->examPartDetail($dataObj, $postDataObj['exam_id']);
            if ($result) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array("marksStructure" => $result));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
