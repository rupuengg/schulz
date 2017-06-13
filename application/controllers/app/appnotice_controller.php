<?php

class appnotice_controller extends CI_Controller {

    public function LoadNoticeData() {
        //$postDataObj = json_decode($this->input->post('data'), TRUE);
       $postDataObj = json_decode('{"adm_no":"1241","access_key":"FG0P9OJECOQWLLMH2FSIZ0JHRS5S0AQ5GGKFUVKW80JJCWS529ES0O0H6VZXVFS2"}', TRUE);
       if(!empty($postDataObj)) {
        $this->load->model('app/appparent_core', 'coreObj');
        $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
        $this->load->model('app/appnotice_model', 'modelObj');
        $resultJsonNotice = $this->modelObj->GetNoticeDetails($dataObj);
        if ($resultJsonNotice) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('noticeData' => $resultJsonNotice));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        }else{
            echo printCustomMsg('ERRINPUT');
        }
    }

    public function LoadMyNoticeData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if(!empty($postDataObj)) {
        $this->load->model('app/appparent_core', 'coreObj');
        $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
        $this->load->model('app/appnotice_model', 'modelObj');
        $resultJsonMyNotice = $this->modelObj->GetMyNotice($dataObj, $postDataObj['notice_id']);
          if ($resultJsonMyNotice) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('myNoticeData' => $resultJsonMyNotice));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
