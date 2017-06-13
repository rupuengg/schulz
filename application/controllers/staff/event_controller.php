<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class event_controller extends MY_Controller {

    public function loadpage($event_id = 0, $team_id = -1) {
        $this->load->model('staff/event_model', 'teamObj');
        $eventTeam = $this->teamObj->getTeamName($team_id);

        $this->load->view('staff/event/manageeventstaff', array("event_id" => $event_id, "team_id" => $team_id, "team_name" => $eventTeam));
    }

    public function addEvent() {
        $this->load->view('staff/event/mgtevent');
    }

    public function loadeventdetail() {
        $event_id = $this->input->post('id');
        $this->load->model('staff/event_model', 'modelObj');
        $eventDetail = $this->modelObj->geteventDetails($event_id);
        $eventDetail = $this->modelObj->geteventDetails($event_id);
        $eventVolStud = $this->modelObj->getvolunteerStudent($event_id);
        $eventVolStaff = $this->modelObj->getvolunteerStaff($event_id);
        $eventTeamLength = $this->modelObj->getTeamLength($event_id);
        $eventTeamMemLength = $this->modelObj->getTeamMemberLength($event_id);
        try {
            echo json_encode(array("eventDetail" => $eventDetail, "volunteerStud" => $eventVolStud, "volunteerStaff" => $eventVolStaff, "ETeamLength" => $eventTeamLength, "ETeamMemLength" => $eventTeamMemLength));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function geteventstaff() {
        $staff_id = $this->session->userdata('staff_id');
        $this->load->model('staff/event_model', 'modelObj');
        $eventList = $this->modelObj->geteventList($staff_id);
        try {
            echo json_encode(array("eventList" => $eventList,));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
