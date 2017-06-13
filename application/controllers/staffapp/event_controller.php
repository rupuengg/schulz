<?php


class event_controller extends CI_Controller {
    
    public function GetEventData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1 && strtoupper($postDataObj['staff_desig']) == 'ADMIN') {
            $this->load->model('staffapp/event_model', 'modelObj');
            $event_data = $this->modelObj->GetEventData($dataObj);
            echo json_encode(array('events' => $event_data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
}
