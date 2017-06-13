<?php

class attendance_controller extends CI_Controller {

    public function GetattData() {
//        $postDataObj = json_decode('{"staff_id":"4","staff_type":"admin","att_date":"2016-01-25","section_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/attendance_model', 'modelObj');
            $att_data = $this->modelObj->attndanceData($dataObj,$postDataObj['staff_id'],$postDataObj['staff_desig'],$postDataObj['section_id'],$postDataObj['att_date']);
            echo json_encode(array('attendancedata' => $att_data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    
    public function GetSection() {
//        $postDataObj = json_decode('{"staff_id":"4","staff_type":"admin","att_date":"2016-01-25","section_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if(strtoupper($postDataObj['staff_desig']) == 'ADMIN'){
            $this->load->model('staffapp/attendance_model', 'modelObj');
            $allclass = $this->modelObj->GetstandardSection($dataObj);
            echo json_encode(array('classes' => $allclass));
        }
        else{
            echo json_encode(array('classes' => 'User not a admin '));
        }
    }
    
    
    
    /* * *************************************Admin Attendance data services********************************** */   
    
    public function GetAttAdminData() {
//        $postDataObj = json_decode('{"staff_id":"4","staff_desig":"admin","school_code":"TESTDB","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1 && strtoupper($postDataObj['staff_desig']) == 'ADMIN') {
            $this->load->model('staffapp/attendance_model', 'modelObj');
            $att_data = $this->modelObj->GetAdminAttData($dataObj,$postDataObj['school_code']);
            echo json_encode(array('attendancedata' => $att_data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
}