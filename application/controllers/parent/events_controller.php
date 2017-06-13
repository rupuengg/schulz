<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class events_controller extends MY_Controller {

    public function LoadEvents() {
        $this->load->view('parent/events_view/events.php');
    }

    public function GetEventsDetails() {
       $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/events_model', 'modelObj');
        $result = $this->modelObj->GetAllEventsDetails($dataObj);
        echo json_encode($result);
    }

    public function GetMyEvents($eventId = -1) {
       $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/events_model', 'modelNewObj');
        $result = $this->modelNewObj->GetEventInformation($eventId,$dataObj);
        $this->load->view('parent/events_view/events.php', array("eventId" => $eventId, "eventdetail" => $result));
    }

}
