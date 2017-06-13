<?php

class homework_model extends CI_Model {

    public function TeacherSubjectList($dbObj, $subject_id, $section_id) {
        $dbObj->select('subject_name');
        $subject_name = $dbObj->get_where('subject_list', array('id' => $subject_id))->row_array();
        $dbObj->select('standard,section');
        $section_name = $dbObj->get_where('section_list', array('id' => $section_id))->row_array();
        $sub_name = $section_name['standard'] . $section_name['section'] . " " . $subject_name['subject_name'];
        return $sub_name;
    }

    public function GetHomeworkData($dataObj, $hwtype) {
        $final_result = array();
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('id,subject_id,section_id');
        $total_hw_id = $dbObj->get_where('homework_master_list', array('entry_by' => $dataObj['id'], 'type' => 'HOMEWORK', 'holiday' => strtoupper($hwtype)))->result_array();
        for ($j = 0; $j < count($total_hw_id); $j++) {
            $sub_name = $this->TeacherSubjectList($dbObj, $total_hw_id[$j]['subject_id'], $total_hw_id[$j]['section_id']);
            $dbObj->select('count(id) as total');
            $total_stu = $dbObj->get_where('homework_student_relation', array('hw_id' => $total_hw_id[$j]['id']))->row_array();
            $dbObj->select('count(id) as open');
            $open_stu = $dbObj->get_where('homework_student_relation', array('hw_id' => $total_hw_id[$j]['id'], 'hw_submit_status' => 'NO'))->row_array();
            $final_result[] = array('hw_type' => $hwtype, 'sub_name' => $sub_name, 'stu_status' => "Total:" . $total_stu['total'] . "|Open:" . $open_stu['open'], 'sec_id' => $total_hw_id[$j]['section_id'], 'sub_id' => $total_hw_id[$j]['subject_id']);
        }
        return $final_result;
    }

    public function GetHomeworkTopicDetail($dataObj, $subject_id, $section_id, $hwtype) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('id,title,hw_date,submission_last_date');
        $section_assigmnt = $dbObj->get_where('homework_master_list', array('entry_by' => $dataObj['id'], 'type' => 'HOMEWORK', 'holiday' => strtoupper($hwtype), 'subject_id' => $subject_id, 'section_id' => $section_id))->result_array();
        $final_result = array();
        for ($j = 0; $j < count($section_assigmnt); $j++) {
            $dbObj->select('count(id) as total_stu');
            $total_stu = $dbObj->get_where('homework_student_relation', array('hw_id' => $section_assigmnt[$j]['id']))->row_array();
            $dbObj->select('count(id) as submitted');
            $open_stu = $dbObj->get_where('homework_student_relation', array('hw_id' => $section_assigmnt[$j]['id'], 'hw_submit_status' => strtoupper('yes')))->row_array();
            $final_result[] = array('hw_title' => $section_assigmnt[$j]['title'], 'total_stu' => $total_stu['total_stu'] . ' students', 'submtd' => $open_stu['submitted'] . ' students submitted the homework', 'post' => date('jS M Y', strtotime($section_assigmnt[$j]['hw_date'])), 'last_date' => date('jS M Y', strtotime($section_assigmnt[$j]['submission_last_date'])), 'hw_id' => $section_assigmnt[$j]['id']);
        }
        return $final_result;
    }

    public function GetAssgmntDetail($dataObj, $hw_id) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $hw_fulldata = $this->GetFullDetail($dbObj, $dataObj['id'], $hw_id);
        $stu_sub = $this->GetSubmDetail($dbObj, $dataObj['id'], $hw_id);
        $nonsub_stu = $this->GetNotSubmDetail($dbObj, $dataObj['id'], $hw_id);
        $full_detail = array('hw_fulldetail' => $hw_fulldata, 'sub_stu' => $stu_sub, 'nonsub_stu' => $nonsub_stu);
        return $full_detail;
    }

    public function GetFullDetail($dbObj, $staff_id, $hw_id) {
        $dbObj->select('title,hw_date,submission_last_date,subject_id,section_id');
        $master_det = $dbObj->get_where('homework_master_list', array('entry_by' => $staff_id, 'type' => 'HOMEWORK', 'id' => $hw_id))->row_array();
        $sub_name = $this->TeacherSubjectList($dbObj, $master_det['subject_id'], $master_det['section_id']);
        $dbObj->select('count(id) as total');
        $total_stu = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id))->row_array();
        $dbObj->select('count(id) as open');
        $open_stu = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id, 'hw_submit_status' => strtoupper('Yes')))->row_array();
        $final_result = $sub_name . ' " ' . $master_det['title'] . ' " on ' . date('dS M Y', strtotime($master_det['hw_date'])) . ' Last Submission Date  ' . date('dS M Y', strtotime($master_det['submission_last_date'])) . ' Submitted by ' . $open_stu['open'] . '/' . $total_stu['total'] . ' Students';
        return $final_result;
    }

    public function GetSubmDetail($dbObj, $staff_id, $hw_id) {
        $final_array = array();
        $dbObj->select('adm_no,timestamp');
        $stu_det = $dbObj->get_where('homework_student_relation', array('entry_by' => $staff_id, 'hw_submit_status' => strtoupper('yes'), 'hw_id' => $hw_id))->result_array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        for ($i = 0; $i < count($stu_det); $i++) {
            $stu_name_pic = $this->coreObj->GetStudentDetail($stu_det[$i]['adm_no'], $dbObj);
            $final_array[] = array('stu_name' => $stu_name_pic['student_name'], 'status' => "Submitted", 'stu_pic' => $stu_name_pic['student_pic'], 'date' => date('dS M Y', strtotime($stu_det[$i]['timestamp'])));
        }
        return $final_array;
    }

    public function GetNotSubmDetail($dbObj, $staff_id, $hw_id) {
        $dbObj->select('adm_no,timestamp');
        $stu_det = $dbObj->get_where('homework_student_relation', array('entry_by' => $staff_id, 'hw_submit_status' => strtoupper('no'), 'hw_id' => $hw_id))->result_array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        for ($i = 0; $i < count($stu_det); $i++) {
            $stu_name_pic = $this->coreObj->GetStudentDetail($stu_det[$i]['adm_no'], $dbObj);
            $final_array[] = array('stu_name' => $stu_name_pic['student_name'], 'status' => "Not Submitted", 'stu_pic' => $stu_name_pic['student_pic']);
        }
        return $final_array;
    }

}
