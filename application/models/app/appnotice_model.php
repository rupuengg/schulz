<?php

class appnotice_model extends CI_Model {

    public function GetNoticeDetails($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
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
                $staffDetail = $this->coreObj->GetStaffName($row['entry_by'], $dbObj);
                $arrTemp = array('timestamp' => $row['timestamp'], "title" => $row['title'], "staff_name" => $staffDetail['name'], "staff_pic" => $staffDetail['profilePic'], "staff_id" => $staffDetail['id'], "notice_type" => $row['notice_type'], "notice_id" => $row['id']);
                $arrFinalNotice[$i] = $arrTemp;
                $i++;
            }
            
        }
        return $arrFinalNotice;
    }

    public function GetMyNotice($dataObj,$noticeId) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj->select('entry_by,timestamp,notice_content');
        $noticeDeatil = $dbObj->get_where('notice_details', array("id" => $noticeId))->row_array();
        if (!empty($noticeDeatil)) {
            $staffDeatil = $this->coreObj->GetStaffName($noticeDeatil['entry_by'], $dbObj);
            $myNotice = array("content" => $noticeDeatil['notice_content'], "staff_name" => $staffDeatil['name'], "staff_id" => $staffDeatil['id'], "timestamp" => $noticeDeatil['timestamp']);
            return $myNotice;
        }
    }

}
