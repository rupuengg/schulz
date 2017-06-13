<?php

class event_model extends CI_Model {

    public function geteventList($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,name,category,subevent_type,on_date,event_end_date,venue,incharge_staff_id,start_time,end_time,report,rules');
        $dbObj->from('event_details');
        $dbObj->where('incharge_staff_id', $staff_id);
        $myTempList = $dbObj->get()->result_array();

        return $myTempList;
    }

    public function geteventDetails($event_id) {
           $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,name,category,subevent_type,on_date,event_end_date,venue,incharge_staff_id,start_time,end_time,report,rules');
        $dbObj->from('event_details');
        $dbObj->where('id', $event_id);
        $myTempDetails = $dbObj->get()->result_array();
        return $myTempDetails;
    }
    public function getvolunteerStudent($event_id) {
           $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $dbObj->from('event_volunteer_student');
        $dbObj->where('event_id', $event_id);
        $volStudent = $dbObj->get()->result_array();
        return $volStudent;
    }
    public function getvolunteerStaff($event_id) {
           $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $dbObj->from('event_volunteer_staff');
        $dbObj->where('event_id', $event_id);
        $volStaff = $dbObj->get()->result_array();
        return $volStaff;
    }
    public function getTeamName($team_id) {
           $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('name');
        $dbObj->from('event_team_detail');
        $dbObj->where('id', $team_id);
        $eventTeamName = $dbObj->get()->result_array();
        return $eventTeamName;
    }

    public function getTeamLength($event_id) {
           $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $dbObj->from('event_team_detail');
        $dbObj->where('event_id', $event_id);
        $eventTeamLength = $dbObj->get()->result_array();
        return $eventTeamLength;
    }
    
    public function getTeamMemberLength($event_id) {
           $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $dbObj->from('event_team_member');
        $dbObj->where('event_id', $event_id);
        $eventTeamMemberLength = $dbObj->get()->result_array();
        return $eventTeamMemberLength;
    }

}

?>
