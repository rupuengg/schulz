<?php

class appmessage_controller extends CI_Controller {

    public function LoadMessageData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appmessage_model', 'modelObj');
            $resultJsonMessage = $this->modelObj->GetMessageDetails($dataObj);
            if ($resultJsonMessage) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('messageDeatil' => $resultJsonMessage));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
//        echo json_encode(array('messageDeatil' => $resultJsonMessage));
    }

}
