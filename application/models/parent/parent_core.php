<?php

class parent_core extends CI_Model {

    public function GetAllSection() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,standard,section');
        $dbObj->where('status', '1');
        $dbObj->order_by('order');
        return $dbObj->get("section_list")->result_array();
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
        if ($cce == 'ALL') {
            
        } else {
            $dbObj->where('cce_applicable', $cce);
        }
        return $dbObj->get("master_class_list")->result_array();
    }

    public function getSectionlist() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('status', '1');
        $dbObj->order_by('order');
        return $dbObj->get("section_list")->result_array();
    }

    public function GetStandardFromSection_id($Section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT standard FROM section_list WHERE id=" . $Section_id;
        $query = $dbObj->query($str)->result_array();
        $standard = $query[0]['standard'];
        return $standard;
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
        $objstddata = $dbObj->query($str)->result_array();
        return $objstddata;
    }

    public function GetStaffName($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('staff_fname,staff_lname,id');
        $staff_detail = $dbObj->get_where('staff_details', array('id' => $staff_id))->result_array();
        $staff = array();
        if (!empty($staff_detail)) {
            $staff['name'] = $staff_detail[0]['staff_fname'] . ' ' . $staff_detail[0]['staff_lname'];
            $staff['id'] = $staff_detail[0]['id'];
            return $staff;
        } else {
            return $staff_detail;
        }
    }

    public function GetAllCCEName($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,caption_show');
        $cce_list = $dbObj->get_where('cce_list', array('class' => $class))->result_array();
        return $cce_list;
    }

    public function GetSubjectListFromSection($section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->distinct();
        $dbObj->select('subject_list.id as sub_id,subject_list.subject_name');
        $dbObj->from('subject_list');
        $dbObj->join('combo_subject_relation', 'subject_list.id=combo_subject_relation.subject_id');
        $dbObj->join('combo_section_relation', 'combo_subject_relation.combo_id=combo_section_relation.combo_id');
        $dbObj->where('combo_section_relation.section_id', $section_id);
        $subjectList = $dbObj->get()->result_array();
        return $subjectList;
    }

    public function GetTermDate() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('date_from,date_to,item');
        $term = $dbObj->get("session_term_setting")->result_array();
        return $term;
    }

    public function GetStudentDetail($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.profile_pic_path_thumbnail as stu_pic,b.section,b.standard');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $stuData = $dbObj->get()->result_array();
        if (!empty($stuData)) {
            $studentData['stuName'] = $stuData[0]['adm_no'] . '.' . $stuData[0]['firstname'] . ' ' . $stuData[0]['lastname'];
            $studentData['adm_no'] = $stuData[0]['adm_no'];
            $studentData['class'] = $stuData[0]['standard'] . $stuData[0]['section'];
            return $studentData;
        } else {
            return -1;
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

    public function GetParentStudent($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.firstname,a.lastname,b.id as section_id,b.section,b.standard as class');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $result = $dbObj->get()->row_array();
        if (!empty($result)) {
            $result['adm_no'] = $adm_no;
            return $result;
        } else {
            return -1;
        }
    }

    public function DateFormatChange($inputDate) {
        $newDateFormat = date('jS M,Y', strtotime($inputDate));
        return $newDateFormat;
    }

}
