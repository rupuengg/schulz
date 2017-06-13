<?php

class appevent_controller extends CI_Controller {

    public function LoadEventData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appevent_model', 'modelObj');
            $resultJsonEvent = $this->modelObj->GetAllEventsDetails($dataObj);
            if ($resultJsonEvent) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('eventSummary' => $resultJsonEvent));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

    public function LoadMyEventData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appevent_model', 'modelObj');
            $resultJsonMyEvent = $this->modelObj->GetEventInformation($dataObj, $postDataObj['event_id']);
            if ($resultJsonMyEvent) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('myEventData' => $resultJsonMyEvent));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
