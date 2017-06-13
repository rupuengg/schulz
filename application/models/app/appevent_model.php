<?php

class appevent_model extends CI_Model {

    public function GetAllEventsDetails($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/parent_core', 'coreObj');
        $eventList = $this->GetEventList($dataObj['adm_no'], $dbObj);
        $arrFinalEvent = array();
        $i = 0;

        foreach ($eventList as $row) {
            $staff_detail = $this->coreObj->GetStaffName($row['entry_by'], $dbObj);
            $teams = $this->GetTeam($row['id'], $dbObj);
            $teamMember = $this->GetTeamMember($row['id'], $dbObj);
            $arrEventDetail = array('timestamp' => $row['timestamp'], 'event_Detail' => $row['work'] . ' in ' . $row['name'], 'eventId' => $row['id'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id'], 'teams' => $teams, 'teamMember' => $teamMember, 'staff_pic' => base_url() . 'index.php/app/getstaffphoto/' . $staff_detail['id'] . '/THUMB');
            $arrFinalEvent[$i] = $arrEventDetail;
            $i++;
        }
        return $arrFinalEvent;
    }

    public function GetEventList($adm_no, $dbObj) {
        $dbObj->select('a.id,a.name,a.category,b.work,b.remark,b.entry_by,b.timestamp');
        $dbObj->from('event_details as a');
        $dbObj->join('event_volunteer_student as b', 'a.id=b.event_id');
        $dbObj->where('b.volunteer_adm_id', $adm_no);
        $dbObj->order_by('b.timestamp', 'desc');
        $dbObj->limit(10);
        $eventsList = $dbObj->get()->result_array();
        return $eventsList;
    }

    public function GetTeamMember($eventId, $dbObj) {
        $dbObj->select('count(id) as teamMember');
        $teamMember = $dbObj->get_where('event_team_member', array('event_id' => $eventId))->result_array();
        return $teamMember;
    }

    public function GetTeam($eventId, $dbObj) {
        $dbObj->select('count(id) as team');
        $teams = $dbObj->get_where('event_team_detail', array('event_id' => $eventId))->result_array();
        return $teams;
    }

    public function GetEventInformation($dataObj, $eventId) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj->select('name,on_date as startDate,venue,incharge_staff_id');
        $eventInfo = $dbObj->get_where('event_details', array('id' => $eventId))->row_array();
        $eventincharge = $this->coreObj->GetStaffName($eventInfo['incharge_staff_id'], $dbObj);
        $staffVolunterr = $this->GetStaffVolunteer($eventId, $dbObj);
        $studentVolunteer = $this->GetStudentVolunteer($eventId, $dbObj);
        $arrStaffVolunteer = array();
        $arrStudentVolunteer = array();
        $finalEventInfo = array();
        foreach ($staffVolunterr as $row) {
            $staffName = $this->coreObj->GetStaffName($row['staff_id'], $dbObj);
            $ctStatus = $this->GetClassteacherStatus($row['staff_id'], $dataObj['section_id'], $dbObj);
            $subjectList = $this->GetTeacherSubject($row['staff_id'], $dataObj['section_id'], $dbObj);
            $staffName['ctStatus'] = $ctStatus;
            $staffName['subjects'] = $subjectList;
            $staffName['type'] = 'STAFF';
            $arrStaffVolunteer[] = $staffName;
        }
        foreach ($studentVolunteer as $row) {
            $student = $this->coreObj->GetStudentDetail($row['adm_no'], $dbObj);
            if ($student != -1) {
                $student['type'] = 'STUDENT';
                $arrStudentVolunteer[] = $student;
            }
        }
        $volunteerArr = array_merge($arrStaffVolunteer, $arrStudentVolunteer);
        $eventDeatil = array('eventName' => $eventInfo['name'], 'detail' => $eventInfo['name'] . ' Event start on ' . date("jS F, Y", strtotime($eventInfo['startDate'])) . ' . Venue of this event is ' . $eventInfo['venue'], 'inchargeName' => $eventincharge['name'], 'inchargePic' => $eventincharge['profilePic']);
        $finalEventInfo['eventInfo'] = $eventDeatil;
        $finalEventInfo['volunteers'] = $volunteerArr;
        return $finalEventInfo;
    }

    public function GetStaffVolunteer($eventId, $dbObj) {
        $dbObj->select('volunteer_staff_id as staff_id');
        $staffVolunteer = $dbObj->get_where('event_volunteer_staff', array('event_id' => $eventId))->result_array();
        return $staffVolunteer;
    }

    public function GetStudentVolunteer($eventId, $dbObj) {
        $dbObj->select('volunteer_adm_id as adm_no');
        $dbObj->group_by('adm_no');
        $studentVolunteer = $dbObj->get_where('event_volunteer_student', array('event_id' => $eventId))->result_array();
        return $studentVolunteer;
    }

    public function GetClassteacherStatus($staff_id, $section_id, $dbObj) {
        $dbObj->select('class_teacher_id');
        $ctStatus = $dbObj->get_where('section_list', array('class_teacher_id' => $staff_id, 'id' => $section_id))->result_array();
        if (!empty($ctStatus)) {
            $ctStatus = "TRUE";
        } else {
            $ctStatus = "FALSE";
        }

        return $ctStatus;
    }

    public function GetTeacherSubject($staff_id, $section_id, $dbObj) {
        $dbObj->select('a.subject_name');
        $dbObj->from('subject_list as a');
        $dbObj->join('subject_staff_relation as b', 'a.id=b.subject_id');
        $dbObj->where('b.staff_id', $staff_id);
        $dbObj->where('b.section_id', $section_id);
        $result = $dbObj->get()->result_array();
        return $result;
    }

}
