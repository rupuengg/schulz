<?php

class apphomework_model extends CI_Model {

    public function GetMyHomeworkData($dataObj) {
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj = $this->load->database($dataObj['database'], TRUE);
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
                $staff_detail = $this->coreObj->GetStaffName($homeWorkData[$i]['entry_by'], $dbObj);
                $arrTemp = array('timestamp' => $row['timestamp'], 'hw_id' => $row['id'], 'detail' => $row['title'] . ' Last date of submission is ' . date("jS F, Y", strtotime($row['submission_last_date'])), 'title' => $row['title'], 'type' => $row['type'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['profilePic']);
                $arrFinalHomework[$i] = $arrTemp;
                $i++;
            }
            return $arrFinalHomework;
        } else {
            return -1;
        }
    }

    public function GetMyHomeworkDetail($dataObj, $hw_id) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        if ($hw_id > 0) {
            $dbObj->select('a.title,a.type,a.hw_date,a.submission_last_date as last_date,count(b.adm_no) as totnumber');
            $dbObj->from('homework_master_list as a');
            $dbObj->join('homework_student_relation as b', 'a.id=b.hw_id');
            $dbObj->where('a.id', $hw_id);
            $homeworkDetail = $dbObj->get()->row_array();
            $completeCount = $this->GetCountCompleteHomework($hw_id, $dbObj);
            $inCompleteCount = $this->GetCountIncompleteHomework($hw_id, $dbObj);
            $studentStatus = $this->GetStudentStatus($hw_id, $dataObj['adm_no'], $dbObj);
            $homeworkDetail['complete'] = $completeCount['count'];
            $homeworkDetail['incomplete'] = $inCompleteCount['count'];
            $homeworkDetail['studentStatus'] = $studentStatus['hw_submit_status'];
            if ($studentStatus['hw_submit_status'] == 'YES') {
                $homeworkDetail['studSubmitDate'] = $studentStatus['submit_date'];
            } else {
                $homeworkDetail['studSubmitDate'] = '';
            }
            if (!empty($homeworkDetail)) {
                return $homeworkDetail;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    public function GetCountIncompleteHomework($hw_id, $dbObj) {
        $dbObj->select('count(adm_no) as count');
        $result = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id, 'hw_submit_status' => 'YES'))->row_array();
        return $result;  
       
    }

    public function GetCountCompleteHomework($hw_id, $dbObj) {
        $dbObj->select('count(adm_no) as count');
        $result = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id, 'hw_submit_status' => 'NO'))->row_array();
         return $result;  
       
    }

    public function GetStudentStatus($hw_id, $adm_no, $dbObj) {
        $result = $dbObj->query('select hw_submit_status, FROM_UNIXTIME(timestamp,"%Y-%m-%d") as submit_date from homework_student_relation where hw_id="' . $hw_id . '" and adm_no="' . $adm_no . '" ')->row_array();
        if(empty($result)){
          return array('hw_submit_status'=>'NA');  
        }else{
          return $result;  
        }
    }

}
