<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class schoolsetting_model extends CI_Model {

    public function GetSchoolDetails() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,school_affiliation_no,school_name,school_board_name,school_address,school_phone,school_logo_path');
        $schoolData = $dbObj->get_where('school_setting')->row_array();
        return $schoolData;
    }

    public function SaveSchoolDetails($dataobj) {
        $dataObj1 = json_encode($dataobj);
        $dataObj2 = json_decode($dataObj1, TRUE);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('school_setting',array('id'=>$dataObj2['id']));
        $arrData = array("school_affiliation_no" => $dataObj2['school_affiliation_no'], "school_name" => $dataObj2['school_name'], 'school_board_name' => $dataObj2['school_board_name'], 'school_address' => $dataObj2['school_address'], 'school_phone' => $dataObj2['school_phone'],'school_logo_path' => $dataObj2['school_logo_path']);
        $dbObj->insert('school_setting', $arrData);
        $insertId = $dbObj->insert_id();
        if ($insertId) {
            return $insertId;
        } else {
            return -1;
        }
    }

}
