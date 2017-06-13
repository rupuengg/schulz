<?php

class marks_model extends CI_Model {

    public function getClassSubject($dataObj) {
        $subjsec = array();
        $class = array();
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('a.section_id,a.subject_id');
        $dbObj->from('subject_staff_relation as a');
        $dbObj->join('section_list as c', 'c.id=a.section_id', 'left');
        $dbObj->where('c.status', '1');
        $dbObj->where('a.staff_id', $dataObj['id']);
        $dbObj->order_by('c.order');
        $subjsec = $dbObj->get()->result_array();
        for ($i = 0; $i < count($subjsec); $i++) {
            $dbObj->select('standard,section');
            $class[] = $dbObj->get_where('section_list', array('id' => $subjsec[$i]['section_id']))->row_array();
            $dbObj->select('subject_name');
            $subj[] = $dbObj->get_where('subject_list', array('id' => $subjsec[$i]['subject_id']))->row_array();
            $finalarr[] = $class[$i]['standard'] . $class[$i]['section'] . "-" . $subj[$i]['subject_name'];
            $classSubjDet[] = array('sec_id' => $subjsec[$i]['section_id'], 'subj_id' => $subjsec[$i]['subject_id'], 'sub_name' => $finalarr[$i]);
        }

        return $classSubjDet;
    }

    public function getExamType($subject_id, $section_id, $dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('id,exam_name');
        $examType = $dbObj->get_where('exam_settings', array('subject_id' => $subject_id, 'section_id' => $section_id))->result_array();
        return $examType;
    }

    public function getMarksData($section_id, $exam_id, $dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $mainExamDetail = $this->getExamDetailById($exam_id, $dbObj);
        $dbObj->select('id,max_marks,part_name');
        $marks = $dbObj->get_where('exam_parts_details', array('exam_id' => $exam_id))->result_array();
        $dbObj->select('adm_no,firstname,lastname');
        $students = $dbObj->get_where('biodata', array('section_id' => $section_id))->result_array();
        $stuMarksData = $this->getStudentMarksData($marks, $students, $dataObj);
        $finalArr = array('exam_id' => $mainExamDetail['exam_id'], 'exam_name' => $mainExamDetail['exam_name'], 'pmarks' => $marks, 'student' => $stuMarksData);
        return $finalArr;
    }

    public function getStudentMarksData($marks, $students, $dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $mainarr = array();
        for ($i = 0; $i < count($students); $i++) {
            $stuarr = array();
            for ($j = 0; $j < count($marks); $j++) {
                $part = $marks[$j]['part_name'];
                $dbObj->select('marks');
                $studentdata = $dbObj->get_where('exam_marks_details', array('adm_no' => $students[$i]['adm_no'], 'exam_part_id' => $marks[$j]['id']))->row_array();
                $stuarr[] = $studentdata['marks'];
            }
            $mainarr[] = array('stu_name' => $students[$i]['adm_no'] . "." . $students[$i]['firstname'] . ' ' . $students[$i]['lastname'], 'stu_marks' => $stuarr);
        }
        return $mainarr;
    }

    public function getExamDetailById($exam_id, $dbObj) {
        $dbObj->select('id as exam_id,exam_name');
        $examType = $dbObj->get_where('exam_settings', array('id' => $exam_id))->row_array();
        return $examType;
    }

}
