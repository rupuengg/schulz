<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class notice_controller extends MY_Controller {

    public function LoadNotice($notice_id=-1) {
        $this->load->model('parent/notice_model','modelObj');
        $noticeDeatil=$this->modelObj->GetMyNotice($notice_id);
        $this->load->view('parent/notice_view/notice.php',array("myNotice"=>$noticeDeatil));
    }

    public function GetNotice() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/notice_model', 'modelObj');
        $result = $this->modelObj->GetNoticeDetails($dataObj);
        echo json_encode($result);
    }

}
