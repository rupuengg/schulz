<?php

class homework_controller extends CI_Controller {

    public function GetHwMainData() {
//        $postDataObj = json_decode('{"staff_id":"1","hw_type":"yes","att_date":"2016-01-25","section_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/homework_model', 'modelObj');
            $hw_data = $this->modelObj->GetHomeworkData($dataObj, $postDataObj['hw_type']);
            echo json_encode(array('homeworkdata' => $hw_data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function GetHwTopics() {
//        $postDataObj = json_decode('{"staff_id":"1","hw_type":"no","subject_id":"51","section_id":"75","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/homework_model', 'modelObj');
            $sub_assg = $this->modelObj->GetHomeworkTopicDetail($dataObj, $postDataObj['subject_id'], $postDataObj['section_id'], $postDataObj['hw_type']);
            echo json_encode(array('hw_managedata' => $sub_assg));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function GetAssgmntDetail() {
//        $postDataObj = json_decode('{"staff_id":"1","hw_id":"39","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/homework_model', 'modelObj');
            $assg_detail = $this->modelObj->GetAssgmntDetail($dataObj, $postDataObj['hw_id']);
            echo json_encode(array('hw_fulldetaildata' => $assg_detail));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

}
