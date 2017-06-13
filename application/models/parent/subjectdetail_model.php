<?php

class subjectdetail_model extends CI_Model {

    public function subjectDetail($subject_id) {
//        print_r($subject_id);
//                exit();
        $home = $this->homeworkdetail($subject_id);
        $subname = $this->getSubjectname($subject_id);
        $currentuser = $this->GetImportentDetails();
        $upexam = $this->upcomingExam($subject_id, $subject_id);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,a.exam_name,b.exam_fullname');
        $dbObj->from('exam_settings as a');
        $dbObj->join('exam_master_list as b', 'a.exam_master_id=b.id');
        $dbObj->where('a.section_id', $currentuser['section_id']);
        $dbObj->where('a.subject_id', $subject_id);
        $tempresult = $dbObj->get()->result_array();
        $garphdata = $this->graphData($subject_id);
//                print_r($garphdata);exit();
        $result['examdetail'] = $tempresult;
        $result['upcomingexam'] = $upexam;
        $result['homework'] = $home;
        $result['subjectname'] = $subname;
        $result['graphdata'] = $garphdata;

        return $result;
    }

    public function graphData($subject_id) {
        $currentuser = $this->GetImportentDetails();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,exam_name');
        $dbObj->where('section_id', $currentuser['section_id']);
        $dbObj->where('subject_id', $subject_id);
        $subject = $this->getSubjectname($subject_id);
        $examNameDeatils = $dbObj->get('exam_settings')->result_array();
        $avgmark[] = array();
        $maxmark[] = array();
        $studentmark[] = array();
        $examName[] = array();
        $j = 0;
        for ($i = 0; $i < count($examNameDeatils); $i++) {
            $avgmark[$j] = $this->getAvgMark($examNameDeatils[$i]['id']);
            $maxmark[$j] = $this->getMaxMark($examNameDeatils[$i]['id']);
            $studentmark[$j] = $this->getStudentSubMark($examNameDeatils[$i]['id'], $currentuser['adm_no']);
            $examName[$j] = $examNameDeatils[$i]['exam_name'];
            $j++;
        }
//        print_r($examName);exit;
        $final['subjectname'] = 'Marks Obtained in :' . $subject['subject_name'];
        $final['graphexamlist'] = $examName;
//        $final['graphexamlist'] = $examName;
        $final['graphsubjectmark'] = $studentmark;
        $final['graphmaxmarklist'] = $maxmark;
        $final['graphavgmarklist'] = $avgmark;
        return $final;
    }

    public function GetAllExamName($section, $subjectid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('exam_name');
        $tempclass = $dbObj->get_where('exam_settings', array('section_id' => $section, 'subject_id' => $subjectid))->result_array();
        if (!empty($tempclass)) {
            return $tempclass;
        } else {
            return 0;
        }
    }

    public function getSubjectname($subject_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('subject_name');
        $subname = $dbObj->get_where('subject_list', array('id' => $subject_id))->row_array();

        if (!empty($subname)) {
            return $subname;
        } else {
            return 0;
        }
    }

    public function GetImportentDetails() {
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.adm_no,b.id as section_id,b.standard as class');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $result = $dbObj->get()->row_array();
        if (!empty($result)) {
            $result;
            return $result;
        } else {
            return -1;
        }
    }

    public function upcomingExam($sectionid, $subject_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("a.exam_id,b.subject_id,c.exam_name,DATE_FORMAT(c.exam_publish_date,'%d/%m/%Y') as publish_date", FALSE);
        $dbObj->from('exam_datesheet_section_relation as a');
        $dbObj->join('exam_datesheet_subject_relation as b', 'a.exam_id=b.exam_id');
        $dbObj->join('exam_datesheet_details as c', 'b.exam_id=c.id');
        $dbObj->where('a.section_id', $sectionid);
        $dbObj->where('b.subject_id', $subject_id);
        $upexam = $dbObj->get()->result_array();

        if (!empty($upexam)) {
            return $upexam;
        } else {
            return 0;
        }
    }

    public function examPartDetail($examid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('part_name,max_marks');
        $result = $dbObj->get_where('exam_parts_details', array('exam_id' => $examid['id']))->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return 0;
        }
    }

    public function homeworkdetail($subject_id) {
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
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
        if (!empty($result)) {
            return $result;
        } else {
            return 0;
        }
    }

    public function examPartId($subjectid, $sectionid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('b . id');
        $dbObj->from('exam_settings as a');
        $dbObj->join('exam_parts_details as b', 'a.id=b.exam_id');
        $dbObj->where('a.subject_id', $subjectid);
        $dbObj->where('a.section_id', $sectionid);
        $partid = $dbObj->get()->result_array();
        return $partid;
    }

    public function getAvgMark($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
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

    public function getMaxMark($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT sum(c.marks) as marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.id= '" . $id . "'  AND c.exam_part_id=b.id AND a.id=b.exam_id GROUP BY c.adm_no order by sum(c.marks) desc LIMIT 1";
        $maxmark = $dbObj->query($query)->row_array();
        if ($maxmark['marks'] != '' || $maxmark['marks'] != null) {
            return (int) $maxmark['marks'];
        } else {
            return 0;
        }
    }

    public function getStudentSubMark($id, $admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT sum(c.marks) as marks FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE a.id= '" . $id . "'  AND c.exam_part_id=b.id AND a.id=b.exam_id AND c.adm_no='" . $admno . "'";
        $studentmark = $dbObj->query($query)->row_array();
        if ($studentmark['marks'] != '' || $studentmark['marks'] != null) {
            return (int) $studentmark['marks'];
        } else {
            return 0;
        }
    }

}
