<?php

class core extends CI_Model {

    public function GetAllSection() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,standard,section');
        $dbObj->where('status', '1');
        $dbObj->order_by('order');
        return $dbObj->get("section_list")->result_array();
    }
    
     public function getActiveClassList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('b.id,a.standard,a.section');
        $dbObj->from('section_list as a');
        $dbObj->join('master_class_list as b', 'a.standard=b.standard');
        $dbObj->where('a.status', '1');
        $dbObj->order_by('a.order');
        $result = $dbObj->get()->result_array();
        return $result;
    }

    public function GetAllStudent($section_id) {

        if ($section_id == "ALL") {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->select('adm_no, adm_no_display, firstname, lastname, sex, dob_date, ad_date, address1, city, state, pin_code, section_id,profile_pic_path_thumbnail, roll_no');
            return $dbObj->get("biodata")->result_array();
        } else {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->select('adm_no, adm_no_display, firstname, lastname, sex, dob_date, ad_date, address1, city, state, pin_code,profile_pic_path_thumbnail, section_id, roll_no');
            return $dbObj->get_where('biodata', array('section_id' => $section_id))->result_array();
        }
    }

    public function getClassList($cce = 'ALL') {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('b.id,a.standard,a.section');
        $dbObj->from('section_list as a');
        $dbObj->join('master_class_list as b', 'a.standard=b.standard');
        $dbObj->where('a.status', '1');
        if ($cce == 'ALL') {
            
        } else {
            $dbObj->where('b.cce_applicable', $cce);
        }
        $dbObj->order_by('a.order');
        return $dbObj->get()->result_array();
    }

    public function getSectionlist($cce = -1) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,a.standard,a.section');
        $dbObj->from('section_list as a');
        $dbObj->join('master_class_list as b', 'a.standard=b.standard');
        $dbObj->where('a.status', '1');
        if ($cce == 'YES') {
            $dbObj->where('b.cce_applicable', $cce);
        }
        $dbObj->order_by('a.order');
        return $dbObj->get()->result_array();
    }

    public function GetStandardFromSection_id($Section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT standard FROM section_list WHERE id=" . $Section_id;
        $query = $dbObj->query($str)->result_array();
        if (!empty($query)) {
            $standard = $query[0]['standard'];
            return $standard;
        }
    }

   
    public function getSectionlistfromclass($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('standard', $class);
        $dbObj->where('status', '1');
        $dbObj->order_by('order');
        return $dbObj->get("section_list")->result_array();
    }

    public function getstaffsubjectlist($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT a.`section_id`,a.`subject_id`,concat( b.`standard`,' ',b.`section`) as class, c.subject_name as subject FROM `subject_staff_relation` as a,section_list as b, subject_list as c WHERE a.section_id=b.id and c.id=a.subject_id and a.staff_id=" . $staff_id . " AND b.status=1";
        //echo $str;exit;
        $objstddata = $dbObj->query($str)->result_array();
        return $objstddata;
    }

    public function GetStudentSubjectList($adm_no, $standard, $dbObj) {
        if ($standard > 10) {
            $selectCol = 'subject_id';
            $tbl_name = 'student_subject_relation';
            $colName = 'adm_no';
            $val = $adm_no;
        } else {
            $selectCol = 'id as subject_id';
            $tbl_name = 'subject_list';
            $colName = 'class_name';
            $val = $standard;
        }
        $dbObj->select($selectCol);
        $subjectIdList = $dbObj->get_where($tbl_name, array($colName => $val))->result_array();
//      echo  $dbObj->last_query();
        foreach ($subjectIdList as $key => $row) {
            $subjectIdList[$key]['subject_name'] = $this->GetSubjectNameById($row['subject_id'], $dbObj);
        }
        return $subjectIdList;
    }

    public function GetSubjectNameById($subjectId, $dbObj) {
        $dbObj->select('subject_name');
        $subjectName = $dbObj->get_where('subject_list', array('id' => $subjectId))->row_array();
        return $subjectName['subject_name'];
    }

    public function GetSchoolTermDetails() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $result = $dbObj->get_where('session_term_setting')->result_array();
        return $result;
    }

    public function getStaffDetail($clsteachrId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('salutation,staff_fname,staff_lname');
        $staffdetails = $dbObj->get_where('staff_details', array('id' => $clsteachrId))->row_array();
        return $staffdetails;
    }

    public function getClassId($standard) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $classid = $dbObj->get_where('master_class_list', array('standard' => $standard))->row_array();
        return $classid;
    }

    public function getClassTeacher($dataObj) {

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("CONCAT(a.salutation,'',a.staff_fname, ' ',a.staff_lname ) as teacher", FALSE);
        $dbObj->from('staff_details as a');
        $dbObj->join('section_list as b', 'a.id=b.class_teacher_id');
        $dbObj->where('b.id', $dataObj->id);
        $classteacher = $dbObj->get()->row_array();
        return $classteacher;
    }

}
