<?php


class lateentry_controller extends CI_Controller {
    
    public function GetLateEntryData() {
        $postDataObj = json_decode('{"staff_id":"1","staff_desig":"admin","school_code":"TESTDB","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
//        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1 && strtoupper($postDataObj['staff_desig']) == 'ADMIN') {
            $this->load->model('staffapp/lateentry_model', 'modelObj');
            $late_data = $this->modelObj->MainLateData($dataObj);
            echo json_encode(array('latedata' => $late_data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
}
