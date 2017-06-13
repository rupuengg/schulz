<?php

class events_model extends CI_Model {

    public function GetAllEventsDetails($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $eventList = $this->GetEventList($dataObj['adm_no']);
        $arrFinalEvent = array();
        $i = 0;
        if (!empty($eventList)) {
            foreach ($eventList as $row) {
                $arrEventDetail = array();
                $eventId = $row['id'];
                $staff_id = $row['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id);
                $teams = $this->GetTeam($eventId);
                $teamMember = $this->GetTeamMember($eventId);
                $arrEventDetail['timestamp'] = $row['timestamp'];
                $arrEventDetail['type'] = 'EVENT';
                $arrEventDetail['data'] = array('work' => $row['work'], 'event_name' => $row['name'], 'eventId' => $eventId, 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id'], 'teams' => $teams, 'teamMember' => $teamMember);
                $arrFinalEvent[$i] = $arrEventDetail;
                $i++;
            }
            return $arrFinalEvent;
        } else {
            return 0;
        }
    }

    public function GetEventList($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,a.name,a.category,b.work,b.remark,b.entry_by,b.timestamp');
        $dbObj->from('event_details as a');
        $dbObj->join('event_volunteer_student as b', 'a.id=b.event_id');
        $dbObj->where('b.volunteer_adm_id', $adm_no);
        $dbObj->order_by('b.timestamp', 'desc');
        $eventsList = $dbObj->get()->result_array();
        return $eventsList;
    }

    public function GetTeamMember($eventId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as teamMember');
        $teamMember = $dbObj->get_where('event_team_member', array('event_id' => $eventId))->result_array();
        if (!empty($teamMember)) {
            $teamMember = $teamMember[0]['teamMember'];
        } else {
            $teamMember = 0;
        }
        return $teamMember;
    }

    public function GetTeam($eventId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as team');
        $teams = $dbObj->get_where('event_team_detail', array('event_id' => $eventId))->result_array();
        if (!empty($teams)) {
            $teams = $teams[0]['team'];
        } else {
            $teams = 0;
        }
        return $teams;
    }

    public function GetEventInformation($eventId, $dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select('name,on_date as startDate,venue,incharge_staff_id');
        $eventInfo = $dbObj->get_where('event_details', array('id' => $eventId))->result_array();
        $eventincharge = $this->coreObj->GetStaffName($eventInfo[0]['incharge_staff_id']);
        $staffVolunterr = $this->GetStaffVolunteer($eventId);
        $studentVolunteer = $this->GetStudentVolunteer($eventId);
        $arrStaffVolunteer = array();
        $arrStudentVolunteer = array();
        $finalEventInfo = array();
        foreach ($staffVolunterr as $row) {
            $staffName = $this->coreObj->GetStaffName($row['staff_id']);
            $ctStatus = $this->GetClassteacherStatus($row['staff_id'], $dataObj['section_id']);
            $subjectList = $this->GetTeacherSubject($row['staff_id'], $dataObj['section_id']);
            $staffName['ctStatus'] = $ctStatus;
            $staffName['subjects'] = $subjectList;
            $arrStaffVolunteer[] = $staffName;
        }
        foreach ($studentVolunteer as $row) {
            $student = $this->coreObj->GetStudentDetail($row['adm_no']);
            if ($student != -1) {
                $arrStudentVolunteer[] = $student;
            }
        }
        $finalEventInfo['eventInfo'] = $eventInfo;
        $finalEventInfo['staffVolun'] = $arrStaffVolunteer;
        $finalEventInfo['stuVolun'] = $arrStudentVolunteer;
        $finalEventInfo['eventInchrg'] = $eventincharge;
        return $finalEventInfo;
    }

    public function GetStaffVolunteer($eventId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('volunteer_staff_id as staff_id');
        $staffVolunteer = $dbObj->get_where('event_volunteer_staff', array('event_id' => $eventId))->result_array();
        return $staffVolunteer;
    }

    public function GetStudentVolunteer($eventId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('volunteer_adm_id as adm_no');
        $dbObj->group_by('adm_no');
        $studentVolunteer = $dbObj->get_where('event_volunteer_student', array('event_id' => $eventId))->result_array();
        return $studentVolunteer;
    }

    public function GetClassteacherStatus($staff_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('class_teacher_id');
        $ctStatus = $dbObj->get_where('section_list', array('class_teacher_id' => $staff_id, 'id' => $section_id))->result_array();
        if (!empty($ctStatus)) {
            $ctStatus = "TRUE";
        } else {
            $ctStatus = "FALSE";
        }

        return $ctStatus;
    }

    public function GetTeacherSubject($staff_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.subject_name');
        $dbObj->from('subject_list as a');
        $dbObj->join('subject_staff_relation as b', 'a.id=b.subject_id');
        $dbObj->where('b.staff_id', $staff_id);
        $dbObj->where('b.section_id', $section_id);
        $result = $dbObj->get()->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            $result = "NA";
            return $result;
        }
    }

}
