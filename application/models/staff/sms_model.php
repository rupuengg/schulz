<?php

class sms_model extends CI_Model {

    public function SmsDetails($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array('sms_content' => $dataObj->message, 'sms_type' => 'SMS', 'sent_to_type' => $dataObj->type, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        $dbObj->insert('sms_details', $data);
        $lastInsertId = $dbObj->insert_id();
        $myInsertArray = array();
        foreach ($dataObj->detail as $row) {
            if (isset($row->smsSend)) {
                if ($row->smsSend) {
                    $myInsertArray[] = array('sms_id' => $lastInsertId, 'sent_to_id' => $dataObj->type == "STAFF" ? $row->id : $row->adm_no, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
                }
            }
        }
        if (count($myInsertArray) > 0) {
            $dbObj->insert_batch('sms_sent_to', $myInsertArray);
            $lastInsertId = $dbObj->insert_id();
            if ($lastInsertId > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return -1;
        }
    }

}
