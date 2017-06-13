<?php

class notice_model extends CI_Model {

    public function NoticeDetail($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array('title' => $dataObj->noticeTitle, 'notice_content' => $dataObj->noticeContent, 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        $dbObj->insert('notice_details', $data);
        $lastInsertId = $dbObj->insert_id();
        $insertNoticeRelation = array();
        foreach ($dataObj->detail as $row) {
            if (isset($row->noticeSend)) {
                if ($row->noticeSend) {
                    $insertNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $dataObj->type == "STAFF" ? $row->id : $row->adm_no, 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
                }
            }
        }
        if (count($insertNoticeRelation) > 0) {
            $dbObj->insert_batch('notice_relation', $insertNoticeRelation);
            $lastInsertId = $dbObj->insert_id();
            return $lastInsertId;
        } else {
            return -1;
        }
    }

    public function DirectNoticeSend($dataObj, $resultDirect) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array('title' => $dataObj->noticeTitle, 'notice_content' => $dataObj->noticeContent, 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        $dbObj->insert('notice_details', $data);
        $lastInsertId = $dbObj->insert_id();
        $insertNoticeRelation = array();
        if ($dataObj->type == 'ALLSTAFF') {
            foreach ($resultDirect as $val) {
                $insertNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $val['id'], 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
            }
            if (count($insertNoticeRelation) > 0) {
                $dbObj->insert_batch('notice_relation', $insertNoticeRelation);
                return true;
            } else {
                return -1;
            }
        }
        if ($dataObj->type == 'ALLSTUDENT') {
            foreach ($resultDirect as $val) {
                $insertNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $val['adm_no'], 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
            }
            if (count($insertNoticeRelation) > 0) {
                $dbObj->insert_batch('notice_relation', $insertNoticeRelation);
                return true;
            } else {
                return -1;
            }
        }
    }

    public function DirectNoticeSendAll($dataObj, $staffDirect, $studentDirect) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array('title' => $dataObj->noticeTitle, 'notice_content' => $dataObj->noticeContent, 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        $dbObj->insert('notice_details', $data);
        $lastInsertId = $dbObj->insert_id();
        $insertStaffNoticeRelation = array();
        $insertStudentNoticeRelation = array();
        if ($dataObj->type == 'SCHOOL') {
            foreach ($staffDirect as $val) {
                $insertStaffNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $val['id'], 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
            }
            foreach ($studentDirect as $row) {
                $insertStudentNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $row['adm_no'], 'notice_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
            }
            if (count($insertStaffNoticeRelation) > 0 && count($insertStudentNoticeRelation) > 0) {
                $dbObj->insert_batch('notice_relation', $insertStaffNoticeRelation);
                $dbObj->insert_batch('notice_relation', $insertStudentNoticeRelation);
                $lastInsertId = $dbObj->insert_id();
                return $lastInsertId;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

}
