<?php

class clubmanagement_controller extends MY_Controller {

    public function AddNewClub() {
        $this->load->view('staff/clubmanagement/addclub_view');
    }

    public function AddMember($clubId = -1, $meetingId = -1) {
        $this->load->model('staff/clubmanagement_model', 'dbobj');
        $clubList = $this->dbobj->GetClubList();
        $clubDetail = null;
        if ($clubId > 0) {
            $clubDetail = $this->dbobj->GetMyClubDetail($clubId);
        }
        $this->load->view('staff/clubmanagement/addmember_view', array("clubList" => $clubList, "clubId" => $clubId, "meetingId" => $meetingId, "clubDetail" => $clubDetail));
    }

    public function GetMemberDetails() {
        $dataObj = json_decode($this->input->post('data'));
        $meetingId = $dataObj->meetingId;
        $clubId = $dataObj->club_id;
        $this->load->model('staff/clubmanagement_model', 'modelObj');
        $result = $this->modelObj->GetMemberDetail($meetingId, $clubId);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveAttDetails() {
        $dataObj = json_decode($this->input->post('data'));
        $this->load->model('staff/clubmanagement_model', 'modelObj');
        $result = $this->modelObj->SaveAttdetail($dataObj);
        if ($result > 0) {
            echo printCustomMsg("TRUE", "Attendance Marked successfully", $result);
        } else {
            echo printCustomMsg("SAVEERR", "Attendance Not Marked", $result);
        }
    }

}
