<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
class appparent_core extends CI_Model {

    public function GetStudentDatabaseName($adm_no, $accessKey) {

        include(APPPATH.'config/database'.EXT);
        $userIdResult = $this->GetUseridFromAdmno($accessKey);
        //print_r($userIdResult); exit;
        $schoolDb = $this->db->get_where('school_db_year_wise', array("school_code" => $userIdResult['school_code'], "current_db" => "YES"))->row_array();
        $dynamicDB = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
        $studentInformation = $this->GetImportentDetails($adm_no, $dynamicDB);
        $studentInformation['database'] = $dynamicDB;
        $studentInformation['userid'] = $userIdResult['user_id'];
        return $studentInformation;
    }

    public function GetUseridFromAdmno($accessKey) {
        $Useridresult = $this->db->get_where('app_access_keys_details', array('access_key' => $accessKey))->row_array();
        //print_r($Useridresult); exit;
        if (!empty($Useridresult)) {
            $result = $this->db->get_where('user_std_relation', array('user_id' => $Useridresult['user_id']))->row_array();
            //print_r($result); exit;
            return $result;
        }else{
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function GetImportentDetails($adm_no, $dynamicDB) {
        $dbObj = $this->load->database($dynamicDB, TRUE);
        $dbObj->select('a.firstname,a.lastname,a.adm_no,b.id as section_id,b.standard as class');
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

    public function GetStaffName($staff_id, $dbObj) {
        $dbObj->select('staff_fname,staff_lname,id');
        $staff_detail = $dbObj->get_where('staff_details', array('id' => $staff_id))->result_array();
        $staff = array();
        if (!empty($staff_detail)) {
            $staff['name'] = $staff_detail[0]['staff_fname'] . ' ' . $staff_detail[0]['staff_lname'];
            $staff['id'] = $staff_detail[0]['id'];
            $staff['profilePic'] = base_url() . 'index.php/app/getstaffphoto/' . $staff_detail[0]['id'] . '/THUMB';
            return $staff;
        } else {
            return $staff_detail;
        }
    }

    public function GetTermDate($dbObj) {
        $dbObj->select('date_from,date_to,item');
        $term = $dbObj->get("session_term_setting")->result_array();
        return $term;
    }

    public function GetAllCCEName($class,$dbObj) {
        $dbObj->select('id,caption_show');
        $cce_list = $dbObj->get_where('cce_list', array('class' => $class))->result_array();
        return $cce_list;
    }

    public function GetStudentDetail($adm_no, $dbObj) {
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.profile_pic_path_thumbnail as stu_pic,b.section,b.standard');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $stuData = $dbObj->get()->result_array();
        if (!empty($stuData)) {
            $studentData['stuName'] = $stuData[0]['adm_no'] . '.' . $stuData[0]['firstname'] . ' ' . $stuData[0]['lastname'];
            $studentData['adm_no'] = $stuData[0]['adm_no'];
            $studentData['class'] = $stuData[0]['standard'] . $stuData[0]['section'];
            $studentData['profilePic'] = base_url() . 'index.php/app/getstudphoto/' . $stuData[0]['adm_no'] . '/THUMB';
            return $studentData;
        } else {
            return -1;
        }
    }

    public function GetSubjectListFromSection($section_id, $dbObj) {
        $dbObj->distinct();
        $dbObj->select('subject_list.id as sub_id,subject_list.subject_name');
        $dbObj->from('subject_list');
        $dbObj->join('combo_subject_relation', 'subject_list.id=combo_subject_relation.subject_id');
        $dbObj->join('combo_section_relation', 'combo_subject_relation.combo_id=combo_section_relation.combo_id');
        $dbObj->where('combo_section_relation.section_id', $section_id);
        $subjectList = $dbObj->get()->result_array();
        return $subjectList;
    }

}
