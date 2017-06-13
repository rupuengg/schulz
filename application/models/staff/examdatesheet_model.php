<?php

class examdatesheet_model extends CI_Model {

    function loadStandars() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('standard,id');
        $dbObj->from('master_class_list');
        $dbObj->order_by("order_by", "asc");
        $standardlist = $dbObj->get()->result_array();
        return $standardlist;
    }

    function loadSection($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('section,id,standard');
        $dbObj->order_by("order", "asc");
        $result = $dbObj->get_where('section_list', array('standard' => $class, 'status' => '1'))->result_array();
        $subject = $this->loadSubject($class);
        $examdetail = $this->loadExam($class);
        $finaldetail = array();
        $finaldetail['sectiondetail'] = $result;
        $finaldetail['subjectdetail'] = $subject;
        $finaldetail['examdetail'] = $examdetail;
        return $finaldetail;
    }

    public function loadSubject($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('subject_name,id');
        $subjectdetail = $dbObj->get_where('subject_list', array('class_name' => $class))->result_array();
        if (!empty($subjectdetail)) {
            return $subjectdetail;
        }
    }

    public function loadExam($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('exam_name');
        $examdeatil = $dbObj->get_where('exam_datesheet_details', array('standard' => $class))->result_array();
        if (!empty($examdeatil)) {
            return $examdeatil;
        }
    }

    public function dateSheet($alldata) {
        $newpublishdate = date('Y-m-d', strtotime($alldata['examData']['examDate']));
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array('exam_name' => $alldata['examData']['examName'], 'standard' => $alldata['sectionList'][0]['standard'], 'section_type' => $alldata['sectionType'], 'exam_publish_date' => $newpublishdate, 'deo_entry_by' => $this->session->userdata('deo_staff_id'), 'entry_by' => $this->session->userdata('staff_id'));
        $dbObj->insert('exam_datesheet_details', $data);
        $examid = $dbObj->insert_id();
        if ($examid > 0) {
            for ($i = 0; $i < count($alldata['sectionList']); $i++) {
                if (isset($alldata['sectionList'][$i]['checked'])) {
                    $insertSectionArr[] = array("section_id" => $alldata['sectionList'][$i]['id'], "exam_id" => $examid, "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
                }
            }
            $dbObj->insert_batch('exam_datesheet_section_relation', $insertSectionArr);
            for ($i = 0; $i < count($alldata['subjectList']); $i++) {
                $newexamdate = date('Y-m-d', strtotime($alldata['subjectList'][$i]['subexamdate']));
                $insertSubjectArr[] = array("subject_id" => $alldata['subjectList'][$i]['sub_id'], "exam_id" => $examid, "exam_date" => $newexamdate, "exam_time" => $alldata['subjectList'][$i]['time'], "duration" => $alldata['subjectList'][$i]['duration'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
            }
            $dbObj->insert_batch('exam_datesheet_subject_relation', $insertSubjectArr);
            return $dbObj->insert_id();
        } else {
            return -1;
        }
    }

}
