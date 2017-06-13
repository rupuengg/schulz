<?php

class appacademics_model extends CI_Model {

    public function LoadStudentMarks($dataObj) {
        $adm_no = $dataObj['adm_no'];
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $query = "SELECT a.id, a.exam_master_id, a.exam_name,sum(c.marks) as marks,a.subject_id,c.timestamp,c.entry_by FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE c. adm_no=$adm_no AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY a.subject_id,a.id ORDER BY a.timestamp DESC LIMIT 20";
        $stuMarks = $dbObj->query($query)->result_array();
        $arrFinalLoadMarks = array();
        $i = 0;
        if (!empty($stuMarks)) {
            foreach ($stuMarks as $row) {
                $arrLoadmarks = array();
                $staff_detail = $this->coreObj->GetStaffName($row['entry_by'], $dbObj);
                $exam_name = $this->GetExamFullName($row['exam_master_id'], $dbObj);
                $subject_name = $this->GetSubjectName($row['id'], $dbObj);
                $marksDeatil = $subject_name.' : Scored ' . $row['marks'] . '/' . $exam_name[0]['max_marks'] . ' in ' . $exam_name[0]['exam_name'];
                $arrLoadmarks = array('type'=>'MARKS','timestamp' => $row['timestamp'], 'remarks' => $marksDeatil, 'exam_name' => $exam_name[0]['exam_name'], 'exam_fullname' => $exam_name[0]['exam_fullname'], 'max_marks' => $exam_name[0]['max_marks'], 'staff_name' => $staff_detail['name'], 'subject' => $subject_name, 'subID' => $row['subject_id'], 'staff_id' => $staff_detail['id'], 'staff_pic' => base_url() . "index.php/app/getstaffphoto/" . $row['entry_by'] . "/THUMB");
                $arrFinalLoadMarks[$i] = $arrLoadmarks;
                $i++;
            }
            return $arrFinalLoadMarks;
        } else {
            return 0;
        }
    }

    public function GetExamFullName($masterId, $dbObj) {
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

    public function GetSubjectName($examId, $dbObj) {
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
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $subject_list = $this->coreObj->GetSubjectListFromSection($dataObj['section_id'], $dbObj);
        $arrMaxMarks = array();
        $arrSubjectName = array();
        $arrAvgMarks = array();
        $arrObtainMarks = array();
        $arrFinalMrk = array();
        $i = 0;
        foreach ($subject_list as $row) {
            $maxMarks = $this->GetMaxMarks($row['sub_id'], $dataObj['section_id'], $dbObj);
            $avgMarks = $this->GetAvgMarks($row['sub_id'], $dataObj['section_id'], $dbObj);
            $stuMarks = $this->GetStuSubjectMarks($dataObj['adm_no'], $row['sub_id'], $dbObj);
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

    public function GetMaxMarks($subject_id, $section_id, $dbObj) {

        $query = "SELECT sum(c.marks) as max_marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.subject_id=$subject_id AND a.section_id=$section_id AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY  a.subject_id,a.id,c.adm_no order by sum(c.marks) desc LIMIT 1 ";
        $maxMarks = $dbObj->query($query)->result_array();
        if (!empty($maxMarks)) {
            $maxMarks = (int) $maxMarks[0]['max_marks'];
        } else {
            $maxMarks = 0;
        }
        return $maxMarks;
    }

    public function GetAvgMarks($subject_id, $section_id, $dbObj) {
        $query = "SELECT sum(c.marks) as marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.subject_id=$subject_id AND a.section_id=$section_id AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY c.adm_no ";
        $avgMarks = $dbObj->query($query)->result_array();
        $count = count($avgMarks);
        $sum = 0;
        foreach ($avgMarks as $row) {
            $sum = $sum + $row['marks'];
        }
        $avgMarks = round($sum / $count);
        return $avgMarks;
    }

    public function GetStuSubjectMarks($adm_no, $subject_id, $dbObj) {
        $query = "SELECT sum(c.marks) as obtain_marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE c. adm_no=$adm_no AND a.subject_id=$subject_id AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY a.subject_id,a.id LIMIT 1";
        $stuMarks = $dbObj->query($query)->result_array();
        if (!empty($stuMarks)) {
            $stuMarks = (int) $stuMarks[0]['obtain_marks'];
        } else {
            $stuMarks = 0;
        }
        return $stuMarks;
    }

}
