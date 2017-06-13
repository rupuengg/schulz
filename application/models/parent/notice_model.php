<?php

class notice_model extends CI_Model {

    public function GetNoticeDetails($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select('a.id,a.title,a.notice_type,a.entry_by,a.timestamp');
        $dbObj->from('notice_details as a');
        $dbObj->join('notice_relation as b', 'a.id=b.notice_id');
        $dbObj->where('b.notice_to_id', $dataObj['adm_no']);
        $dbObj->order_by('timestamp', 'desc');
        $noticeDeatil = $dbObj->get()->result_array();
        $arrFinalNotice = array();
        $i = 0;
        if (!empty($noticeDeatil)) {
            foreach ($noticeDeatil as $row) {
                $staff_id = $row['entry_by'];
                $staffDetail = $this->coreObj->GetStaffName($staff_id);
                $arrTemp = array();
                $arrTemp['timestamp'] = $row['timestamp'];
                $arrTemp['type'] = 'NOTICE';
                $arrTemp['data'] = array("title" => $row['title'], "staff_name" => $staffDetail['name'], "staff_id" => $staffDetail['id'], "notice_type" => $row['notice_type'], "notice_id" => $row['id']);
                $arrFinalNotice[$i] = $arrTemp;
                $i++;
            }
            return $arrFinalNotice;
        } else {
            return -1;
        }
    }

    public function GetMyNotice($noticeId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select('entry_by,timestamp,notice_content');
        $noticeDeatil = $dbObj->get_where('notice_details', array("id" => $noticeId))->result_array();
        if (!empty($noticeDeatil)) {
            $staff_id = $noticeDeatil[0]['entry_by'];
            $staffDeatil = $this->coreObj->GetStaffName($staff_id);
            $myNotice = array("content" => $noticeDeatil[0]['notice_content'], "staff_name" => $staffDeatil['name'], "staff_id" => $staffDeatil['id'], "timestamp" => $noticeDeatil[0]['timestamp']);
            return $myNotice;
        }
    }

}
