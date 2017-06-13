<?php

class homework_model extends CI_Model {

    public function GetMyHomeworkData($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,a.title,a.type,a.hw_date,a.submission_last_date,a.entry_by,a.timestamp');
        $dbObj->from('homework_master_list as a');
        $dbObj->join('homework_student_relation as b', 'a.id=b.hw_id');
        $dbObj->order_by('a.timestamp', 'desc');
        $dbObj->where('b.adm_no', $dataObj['adm_no']);
        $homeWorkData = $dbObj->get()->result_array();
        if (!empty($homeWorkData)) {
            $arrFinalHomework = array();
            $i = 0;
            foreach ($homeWorkData as $row) {
                $staff_id = $homeWorkData[$i]['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id);
                $arrTemp = array();
                $arrTemp['timestamp'] = $row['timestamp'];
                $arrTemp['type'] = 'HOMEWORK';
                $arrTemp['data'] = array('hw_id' => $row['id'], 'last_date' => $row['submission_last_date'], 'title' => $row['title'], 'type' => $row['type'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id']);
                $arrFinalHomework[$i] = $arrTemp;
                $i++;
            }
            return $arrFinalHomework;
        } else {
            return -1;
        }
    }

    public function GetMyHomeworkDetail($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($hw_id > 0) {
            $dbObj->select('a.title,a.type,a.hw_date,a.submission_last_date as last_date,count(b.adm_no) as totnumber');
            $dbObj->from('homework_master_list as a');
            $dbObj->join('homework_student_relation as b', 'a.id=b.hw_id');
            $dbObj->where('a.id', $hw_id);
            $homeworkDetail = $dbObj->get()->row_array();
            $completeCount = $this->GetCountCompleteHomework($hw_id);
            $inCompleteCount = $this->GetCountIncompleteHomework($hw_id);
            $studentStatus = $this->GetStudentStatus($hw_id);
            $homeworkDetail['complete'] = $completeCount['count'];
            $homeworkDetail['incomplete'] = $inCompleteCount['count'];
            $homeworkDetail['studentStatus'] = $studentStatus['hw_submit_status'];
            if ($studentStatus['hw_submit_status'] == 'YES') {
                $homeworkDetail['studSubmitDate'] = date('d M,Y',strtotime($studentStatus['submit_date']));
            } else {
                $homeworkDetail['studSubmitDate'] = '';
            }
            return $homeworkDetail;
        } else {
            return -1;
        }
    }

    public function GetCountIncompleteHomework($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(adm_no) as count');
        $result = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id, 'hw_submit_status' => 'YES'))->row_array();
        return $result;
    }

    public function GetCountCompleteHomework($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(adm_no) as count');
        $result = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id, 'hw_submit_status' => 'NO'))->row_array();
        return $result;
    }

    public function GetStudentStatus($hw_id) {
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $result = $dbObj->query("select hw_submit_status, timestamp as submit_date from homework_student_relation where hw_id='" . $hw_id . "' and adm_no='" . $adm_no . "'",FALSE)->row_array();
        return $result;
    }

}
