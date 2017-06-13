<?php

class clubmanagement_model extends CI_Model {

    public function GetClubList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $staff_id = $this->session->userdata('staff_id');
        $dbObj->select('id,name');
        $clubList = $dbObj->get('club_details')->result_array();
        return $clubList;
    }

    public function GetMemberdetail($meetingId, $clubId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.firstname,a.lastname,a.adm_no');
        $dbObj->from('biodata as a');
        $dbObj->join('club_member as b', 'a.adm_no=b.adm_no');
        $dbObj->where('club_id', $clubId);
        $memberDetails = $dbObj->get()->result_array();
        for ($i = 0; $i < count($memberDetails); $i++) {
            $dbObj->select('meeting_att_status');
            $tempArr = $dbObj->get_where('club_meeting_member', array('adm_no' => $memberDetails[$i]['adm_no'], 'meeting_id' => $meetingId))->result_array();
            if (!empty($tempArr)) {
                if ($tempArr[0]['meeting_att_status'] == 'active') {
                    $memberDetails[$i]['attstatus'] = 'true';
                } else {
                    $memberDetails[$i]['attstatus'] = 'false';
                }
            } else {
                $memberDetails[$i]['attstatus'] = 'false';
            }
        }
        $finalAttArr = Array();
        $finalAttArr['memberAttDetails'] = $memberDetails;
        $meetinIdStatus = $dbObj->get_where('club_meeting_member', array('meeting_id' => $meetingId))->result_array();
        if (!empty($meetinIdStatus)) {
            $saveAtt = 'NO';
        } else {
            $saveAtt = 'YES';
        }
        $finalAttArr['saveAttStatus'] = $saveAtt;
        if (!empty($finalAttArr)) {
            return $finalAttArr;
        } else {
            return -1;
        }
    }

    public function SaveAttDetail($dataObj) {


        $meeting_id = $dataObj->meetingId;
        $staff_id = $this->session->userdata('staff_id');
        $deo_staff_id = $this->session->userdata('deo_staff_id');
        $dataNew = json_encode($dataObj->details->memberAttDetails);
        $memberDetail = json_decode($dataNew, TRUE);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);

        $insertArr = array();
        for ($i = 0; $i < count($memberDetail); $i++) {
            if (isset($memberDetail[$i]['status'])) {
                $insertArr[] = array('meeting_id' => $meeting_id, 'adm_no' => $memberDetail[$i]['adm_no'], 'meeting_att_status' => 'active', 'entry_by' => $staff_id, 'deo_entry_by' => $deo_staff_id);
            } else {
                $insertArr[] = array('meeting_id' => $meeting_id, 'adm_no' => $memberDetail[$i]['adm_no'], 'meeting_att_status' => 'deactive', 'entry_by' => $staff_id, 'deo_entry_by' => $deo_staff_id);
            }
        }
        $dbObj->insert_batch('club_meeting_member', $insertArr);
        $lastinsertid = $dbObj->insert_id();

        if ($lastinsertid > 0) {
            return $lastinsertid;
        } else {
            return -1;
        }
    }

    public function GetMyClubDetail($clubId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $countMember = $this->GetCountMember($clubId);
        $countmeeting=$this->GetCountMeetings($clubId);
        $dbObj->select('a.name,b.staff_fname,b.staff_lname,a.incharge_id');
        $dbObj->from('club_details as a');
        $dbObj->join('staff_details as b', 'a.incharge_id=b.id');
        $dbObj->where('a.id', $clubId);
        $clubDetail = $dbObj->get()->result_array();
        if (!empty($clubDetail)) {
            $clubDetail[0]['countmember'] = $countMember[0]['count'];
            $clubDetail[0]['countmeeting'] = $countmeeting[0]['countmeetings'];
            return $clubDetail;
        } else {
            return -1;
        }
    }

    public function GetCountMember($clubId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(adm_no) as count');
        $result = $dbObj->get_where('club_member', array('club_id' => $clubId))->result_array();
        return $result;
    }
public function GetCountMeetings($clubId){
    $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(club_id) as countmeetings');
        $result1=$dbObj->get_where('club_meetings', array('club_id' => $clubId))->result_array();
        return $result1;
}
}
