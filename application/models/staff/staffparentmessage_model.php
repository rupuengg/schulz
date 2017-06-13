<?php

class staffparentmessage_model extends CI_Model {

    public function GetConversationLength($staff_id, $adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("count(id) as totalSms");
        $dbObj->from('staff_student_message');
        $dbObj->where('staff_id', $staff_id);
        $dbObj->where('adm_no', $adm_no);
        $resultTemp = $dbObj->get()->result_array();
        return $resultTemp;
    }

    public function GetStudNameFrmSubModel($subject_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.profile_pic_path_thumbnail');
        $dbObj->from('biodata a');
        $dbObj->join('student_subject_relation b', 'a.adm_no = b.adm_no');
        $dbObj->where('b.subject_id', $subject_id);
        $query = $dbObj->get()->result_array();
        return $query;
    }

    public function SaveSendMessageModel($myMessage, $staff_id, $adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data_status = array(
            'sender' => 'STAFF',
            'adm_no' => $adm_no,
            'staff_id' => $staff_id,
            'message' => $myMessage['message'],
            'student_read_status' => 'UNREAD',
            'staff_read_status' => 'READ'
        );
        $dbObj->insert('staff_student_message', $data_status);
        $myTempResult = $this->GetSmsDetailModel($staff_id, $adm_no);
        if ($dbObj->affected_rows() == 0) {
            return false;
        } else {
            return $myTempResult;
        }
    }

    public function UpdateStatusModel($staff_id, $adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dataReadStatus = array(
            'student_read_status' => 'READ',
            'student_read_timestamp' => date('Y-m-d h:i:s', time())
        );
        $dbObj->where('staff_id', $staff_id);
        $dbObj->where('adm_no', $adm_no);
        $dbObj->where('sender', 'STUDENT');
        $dbObj->update('staff_student_message', $dataReadStatus);
        if ($dbObj->affected_rows > 0){
            return true;
        }else {
            return false;
        }
    }

    public function GetSmsDetailModel($staff_id, $adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("id,message,sender,student_read_status,staff_read_status,DATE_FORMAT(`timestamp`,'%d %M, %Y') as mytimestamp,timestamp", FALSE);
        $dbObj->from('staff_student_message');
        $dbObj->where('staff_id', $staff_id);
        $dbObj->where('adm_no', $adm_no);
        //$dbObj->order_by('timestamp', 'DESC');
        $query = $dbObj->get()->result_array();
        // echo json_encode($query);
        return $query;
    }

}

?>
