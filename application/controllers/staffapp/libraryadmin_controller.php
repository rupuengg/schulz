<?php

class libraryadmin_controller extends CI_Controller {

    public function GetLibData() {
        $postDataObj = json_decode('{"staff_id":"1","staff_desig":"ADMIN","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
//        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1 && strtoupper($postDataObj['staff_desig']) == 'ADMIN') {
            $this->load->model('staffapp/libraryadmin_model', 'modelObj');
            $Lib_Data = $this->modelObj->MainLibData($dataObj);
            echo json_encode(array('library' => $Lib_Data));
        }else{
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
}