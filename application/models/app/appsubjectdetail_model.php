<?php

class appsubjectdetail_model extends CI_Model {

    public function subjectDetail($dataObj, $subject_id) {
        $adm_no = $dataObj['adm_no'];
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $home = $this->homeworkdetail($subject_id, $dataObj);
        $subname = $this->getSubjectname($subject_id, $dbObj);
        $upexam = $this->upcomingExam($subject_id, $subject_id, $dbObj);

        $dbObj->select('a.id,a.exam_name,b.exam_fullname');
        $dbObj->from('exam_settings as a');
        $dbObj->join('exam_master_list as b', 'a.exam_master_id=b.id');
        $dbObj->where('a.section_id', $dataObj['section_id']);
        $dbObj->where('a.subject_id', $subject_id);
        $tempresult = $dbObj->get()->result_array();
        $garphdata = $this->graphData($dataObj, $subject_id, $dbObj);
        $result['examdetail'] = $tempresult;
        $result['upcomingexam'] = $upexam;
        $result['homework'] = $home;
        $result['subjectname'] = $subname['subject_name'];
        $result['graphdata'] = $garphdata;
        return $result;
    }

    public function graphData($dataObj, $subject_id, $dbObj) {
        $subject = $this->getSubjectname($subject_id, $dbObj);
        $dbObj->select('id,exam_name');
        $dbObj->where('section_id', $dataObj['section_id']);
        $dbObj->where('subject_id', $subject_id);
        $examNameDeatils = $dbObj->get('exam_settings')->result_array();
        $avgmark[] = array();
        $maxmark[] = array();
        $studentmark[] = array();
        $examName[] = array();
        $j = 0;
        for ($i = 0; $i < count($examNameDeatils); $i++) {
            $avgmark[$j] = $this->getAvgMark($examNameDeatils[$i]['id'], $dbObj);
            $maxmark[$j] = $this->getMaxMark($examNameDeatils[$i]['id'], $dbObj);
            $studentmark[$j] = $this->getStudentSubMark($examNameDeatils[$i]['id'], $dataObj['adm_no'], $dbObj);
            $examName[$j] = $examNameDeatils[$i]['exam_name'];
            $j++;
        }

        $final['subjectname'] = 'Marks Obtained in :' . $subject['subject_name'];
        $final['graphexamlist'] = $examName;
        $final['graphsubjectmark'] = $studentmark;
        $final['graphmaxmarklist'] = $maxmark;
        $final['graphavgmarklist'] = $avgmark;
        return $final;
    }

    public function getSubjectname($subject_id, $dbObj) {
        $dbObj->select('subject_name');
        $subname = $dbObj->get_where('subject_list', array('id' => $subject_id))->row_array();


        return $subname;
    }

    public function upcomingExam($sectionid, $subject_id, $dbObj) {
        $dbObj->select("a.exam_id,b.subject_id,c.exam_name,DATE_FORMAT(c.exam_publish_date,'%d/%m/%Y') as publish_date", FALSE);
        $dbObj->from('exam_datesheet_section_relation as a');
        $dbObj->join('exam_datesheet_subject_relation as b', 'a.exam_id=b.exam_id');
        $dbObj->join('exam_datesheet_details as c', 'b.exam_id=c.id');
        $dbObj->where('a.section_id', $sectionid);
        $dbObj->where('b.subject_id', $subject_id);
        $upexam = $dbObj->get()->result_array();


        return $upexam;
    }

    public function examPartDetail($dataObj, $examid) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('part_name,max_marks');
        $result = $dbObj->get_where('exam_parts_details', array('exam_id' => $examid))->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return 0;
        }
    }

    public function homeworkdetail($subject_id, $dataObj) {
        $adm_no = $dataObj['adm_no'];
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select("a.hw_id,b.title,b.type,DATE_FORMAT(b.submission_last_date,'%d/%m/%Y')as submission_last_date,b.entry_by,b.timestamp", FALSE);
        $dbObj->from('homework_student_relation as a');
        $dbObj->join('homework_master_list as b', 'a.hw_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $dbObj->where('b.subject_id', $subject_id);
        $result = $dbObj->get()->result_array();

        for ($i = 0; $i < count($result); $i++) {
            $staff_name = $this->coreObj->GetStaffName($result[$i]['entry_by']);
            $result[$i]['staff_name'] = $staff_name['name'];
        }

        return $result;
    }

    public function getAvgMark($id, $dbObj) {
        $query = "SELECT sum(c.marks) as marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.id= '" . $id . "'  AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY c.adm_no";
        $stuMarks = $dbObj->query($query)->result_array();
        $sum = 0;
        $count = count($stuMarks);
        foreach ($stuMarks as $row) {
            $sum = $sum + $row['marks'];
        }
        $avgMarks = round($sum / $count);
        if ($avgMarks != '' || $avgMarks['marks'] != 0) {
            return (int) $avgMarks;
        } else {
            return 0;
        }
    }

    public function getMaxMark($id, $dbObj) {
        $query = "SELECT sum(c.marks) as marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.id= '" . $id . "'  AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY c.adm_no order by sum(c.marks) desc LIMIT 1";
        $maxmark = $dbObj->query($query)->row_array();
        if ($maxmark['marks'] != '' || $maxmark['marks'] != null) {
            return (int) $maxmark['marks'];
        } else {
            return 0;
        }
    }

    public function getStudentSubMark($id, $admno, $dbObj) {
        $query = "SELECT sum(c.marks) as marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.id= '" . $id . "'  AND c.exam_part_id=b.id AND a.id=b.exam_id AND c.adm_no='" . $admno . "'";
        $studentmark = $dbObj->query($query)->row_array();
        if ($studentmark['marks'] != '' || $studentmark['marks'] != null) {
            return (int) $studentmark['marks'];
        } else {
            return 0;
        }
    }

}
