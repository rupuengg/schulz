<?php

class academics_model extends CI_Model {

    public function LoadStudentMarks($dataObj) {
        $adm_no = $dataObj['adm_no'];
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $query = "SELECT a.id, a.exam_master_id, a.exam_name,sum(c.marks) as marks,a.subject_id,c.timestamp,c.entry_by FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE c. adm_no=$adm_no AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY a.subject_id,a.id";
        $stuMarks = $dbObj->query($query)->result_array();
        $arrFinalLoadMarks = array();
        $i = 0;
        if (!empty($stuMarks)) {
            foreach ($stuMarks as $row) {
                $arrLoadmarks = array();
                $staffId = $row['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staffId);
                $exam_name = $this->GetExamFullName($row['id']);
                $subject_name = $this->GetSubjectName($row['id']);
                $arrLoadmarks['timestamp'] = $row['timestamp'];
                $arrLoadmarks['type'] = 'MARKS';
                $arrLoadmarks['data'] = array('marks' => $row['marks'], 'exam_name' => $exam_name[0]['exam_name'], 'exam_fullname' => $exam_name[0]['exam_fullname'], 'max_marks' => $exam_name[0]['max_marks'], 'staff_name' => $staff_detail['name'], 'subject' => $subject_name, 'subID' => $row['subject_id'], 'staff_id' => $staff_detail['id']);
                $arrFinalLoadMarks[$i] = $arrLoadmarks;
                $i++;
            }
            return $arrFinalLoadMarks;
        } else {
            return 0;
        }
    }

    public function GetExamFullName($masterId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('exam_master_list.exam_fullname,exam_master_list.exam_name,exam_master_list.max_marks');
        $dbObj->from('exam_master_list');
        $dbObj->join('exam_settings', 'exam_master_list.id=exam_settings.exam_master_id');
        $dbObj->where('exam_settings.id', $masterId);
        $result = $dbObj->get()->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return "No Exam Declared";
        }
    }

    public function GetSubjectName($examId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('subject_list.subject_name');
        $dbObj->from('subject_list');
        $dbObj->join('exam_settings', 'subject_list.id=exam_settings.subject_id');
        $dbObj->where('exam_settings.id', $examId);
        $subName = $dbObj->get()->result_array();
        if (!empty($subName)) {
            $subject_name = $subName[0]['subject_name'];
            return $subject_name;
        } else {
            return "No Subject Asign";
        }
    }

    public function GetGraphData($dataObj) {
        $adm_no = $dataObj['adm_no'];
        $section_id = $dataObj['section_id'];
        $this->load->model('parent/parent_core', 'coreObj');
        $subject_list = $this->coreObj->GetSubjectListFromSection($section_id);
        $arrMaxMarks = array();
        $arrSubjectName = array();
        $arrAvgMarks = array();
        $arrObtainMarks = array();
        $arrFinalMrk = array();
        $i = 0;
        foreach ($subject_list as $row) {
            $sub_id = $row['sub_id'];
            $maxMarks = $this->GetMaxMarks($sub_id, $section_id);
            $avgMarks = $this->GetAvgMarks($sub_id, $section_id);
            $stuMarks = $this->GetStuSubjectMarks($adm_no, $sub_id, $section_id);
            $arrSubjectName[$i] = $row['subject_name'];
            $arrMaxMarks[$i] = $maxMarks;
            $arrAvgMarks[$i] = $avgMarks;
            $arrObtainMarks[$i] = $stuMarks;
            $i++;
        }
        $arrFinalMrk['subject_list'] = $arrSubjectName;
        $arrFinalMrk['max_marks'] = $arrMaxMarks;
        $arrFinalMrk['avg_marks'] = $arrAvgMarks;
        $arrFinalMrk['obtain_marks'] = $arrObtainMarks;
        return $arrFinalMrk;
    }

    public function GetMaxMarks($subject_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT sum(c.marks) as max_marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.subject_id=$subject_id AND a.section_id=$section_id AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY c.adm_no order by sum(c.marks) desc LIMIT 1 ";

        $maxMarks = $dbObj->query($query)->result_array();
        if (!empty($maxMarks)) {
            $maxMarks = (int) $maxMarks[0]['max_marks'];
        } else {
            $maxMarks = 0;
        }
        return $maxMarks;
    }

    public function GetAvgMarks($subject_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT sum(c.marks) as marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.subject_id=$subject_id AND a.section_id=$section_id AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY c.adm_no ";

        $avgMarks = $dbObj->query($query)->result_array();
        if (!empty($avgMarks)) {
            $count = count($avgMarks);
            $sum = 0;
            foreach ($avgMarks as $row) {
                $sum = $sum + $row['marks'];
            }
            $avgMarks = round($sum / $count);
        } else {
            $avgMarks = 0;
        }

        return $avgMarks;
    }

    public function GetStuSubjectMarks($adm_no, $subject_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
//        $query = "SELECT sum(c.marks) as obtain_marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE c. adm_no=$adm_no AND a.subject_id=$subject_id AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY a.subject_id,a.id LIMIT 1";

        $query = "SELECT sum(c.marks) as obtain_marks FROM `exam_parts_details` as a,exam_settings as b,exam_marks_details as c WHERE a.`exam_id`=b.`id` AND a.id=c.exam_part_id AND b.subject_id=$subject_id AND b.section_id=$section_id AND c.adm_no=$adm_no"; //Amit chauhan query
        $stuMarks = $dbObj->query($query)->result_array();
        if (!empty($stuMarks)) {
            $stuMarks = (int) $stuMarks[0]['obtain_marks'];
        } else {
            $stuMarks = 0;
        }
        return $stuMarks;
    }

}
