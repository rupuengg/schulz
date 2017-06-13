<?php

class ccegrades_controller extends CI_Controller {

    public function GetcceData() {
//        $postDataObj = json_decode('{"term":"1","staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/ccegrades_model', 'modelObj');
            $cce_data = $this->modelObj->GetCCENameList($dataObj);
            echo json_encode(array('ccegradedata' => $cce_data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function GetStudentccegradeData() {
//        $postDataObj = json_decode('{"term":"1","cce_name":"Part II A : LIFE SKILLS - Empathy","cce_id":"92","section_id":"75","staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/ccegrades_model', 'modelObj');
            $studentcce_data = $this->modelObj->GetStudentccegradeData($dataObj, $postDataObj['term'], $postDataObj['section_id'], $postDataObj['cce_id']);
            if ($studentcce_data == -1) {
                echo json_encode(array(printCustomMsg('ERROR', 'Class is not active,please contact to school admin..', -1)));
            } else {
                echo json_encode(array('stuccegrade' => $studentcce_data));
            }
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

}
