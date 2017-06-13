<?php

class studentclass {

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function GetBasicStudentDeatil($dbname, $adm_no) {
        $dbObj = $this->CI->load->database($dbname, TRUE);
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.sex,a.e_mail,a.dob_date,a.ad_date,a.address1,a.address2,a.roll_no,a.section_id,b.standard,b.section');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $result = $dbObj->get()->row_array();
        return $result;
    }

    public function GetStudentGaurdianDeatil($dbname, $adm_no) {
        $dbObj = $this->CI->load->database($dbname, TRUE);
        $dbObj->select('relation,g_name,g_quali,g_occp,g_desig,g_dept,g_mob,g_mail');
        $result = $dbObj->get_where('gaurdian_details', array('adm_no' => $adm_no))->result_array();
        return $result;
    }

    public function GetStudentMedicalDeatil($dbname, $adm_no) {
        $dbObj = $this->CI->load->database($dbname, TRUE);
        $dbObj->select('blood_group,height,weight,vision_left,vision_right,teeth,hygiene,allergies,medication');
        $result = $dbObj->get_where('medical_details', array('adm_no' => $adm_no))->row_array();
        if (!empty($result)) {
            return $result;
        } else {
            return array('blood_group' => 'NA', 'height' => 'NA', 'weight' => 'NA', 'medication' => 'NA', 'vision_left' => 'NA', 'vision_right' => 'NA', 'teeth' => 'NA', 'hygiene' => 'NA', 'allergies' => 'NA');
        }
    }

    public function GetStudentCard($dbname, $adm_no) {
        $dbObj = $this->CI->load->database($dbname, TRUE);
        $dbObj->select('count(id) as count,card_type as card_name');
        $dbObj->group_by('card_type');
        $result = $dbObj->get_where('cards_details', array('adm_no' => $adm_no))->result_array();
        return $result;
    }

    public function GetStudentStandard($dbname, $adm_no) {
        $studentDeatil = $this->GetBasicStudentDeatil($dbname, $adm_no);
        return $studentDeatil['standard'];
    }

}
