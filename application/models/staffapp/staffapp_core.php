<?php

class staffapp_core extends CI_Model {

    public function GetStaffDatabaseName($staff_id, $accessKey) {
        include(APPPATH . 'config/database' . EXT);
        $userIdResult = $this->GetUseridFromstaffid($accessKey);
        if ($userIdResult != -1) {
            $schoolDb = $this->db->get_where('school_db_year_wise', array("school_code" => $userIdResult['school_code']))->row_array();
            $dynamicDB = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
            $staffInformation = $this->GetImportentDetails($staff_id, $dynamicDB);
            $staffInformation['staff_pic'] = base_url() . "index.php/app/getstaffphoto/" . $staff_id . "/THUMB";
            $staffInformation['database'] = $dynamicDB;
            $staffInformation['userid'] = $userIdResult['id'];
            $staffInformation['School_code'] = $userIdResult['school_code'];
            return $staffInformation;
        }else{
            return -1;
        }
    }

    public function GetUseridFromstaffid($accessKey) {
        $Useridresult = $this->db->get_where('app_access_keys_details', array('access_key' => $accessKey))->row_array();

        if (!empty($Useridresult)) {
            $result = $this->db->get_where('system_users', array('id' => $Useridresult['user_id']))->row_array();
            return $result;
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function GetImportentDetails($staff_id, $dynamicDB) {
        $dbObj = $this->load->database($dynamicDB, TRUE);
        $dbObj->select('a.staff_fname,a.staff_lname,a.id,a.staff_type,b.standard as class,b.section as section');
        $dbObj->from('staff_details as a');
        $dbObj->join('section_list as b', 'a.id=b.class_teacher_id');
        $dbObj->where('a.id', $staff_id);
        $result = $dbObj->get()->row_array();
        if (!empty($result)) {
            $result;
            return $result;
        } else {
            return -1;
        }
    }

    public function GetStaffName($staff_id, $dbObj) {
        $dbObj->select('staff_fname,staff_lname');
        $result = $dbObj->get_where('staff_details', array('id' => $staff_id))->row_array();
        if (!empty($result)) {
            $result['staff_name'] = $result['staff_fname'] . " " . $result['staff_lname'];
            $result['staff_pic'] = base_url() . "index.php/app/getstaffphoto/" . $staff_id . "/THUMB";
            return $result;
        } else {
            echo $dbObj->last_query();
            exit;
        }
    }

    public function GetStudentDetail($adm_no, $dbObj) {
        $dbObj->select('a.firstname,a.lastname,b.standard as standard,b.section as section');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $result = $dbObj->get()->row_array();
        if (!empty($result)) {
            $result_det['student_name'] = $adm_no . "." . $result['firstname'] . " " . $result['lastname'];
            $result_det['student_pic'] = base_url() . "index.php/app/getstudphoto/" . $adm_no . "/THUMB";
            $result_det['class'] = $result['standard'] . $result['section'];
            return $result_det;
        }
    }

    public function GetUserIdFromType($staff_id, $userType, $school_code) {
        if ($userType == 'STAFF') {
            $result = $this->db->get_where('system_users', array('staff_id' => $staff_id, 'member_type' => $userType, 'school_code' => $school_code))->row_array();
            if (!empty($result)) {
                return $result['id'];
            } else {
                return -1;
            }
        } else if ($userType == 'PARENT') {
            $result = $this->db->get_where('user_std_relation', array('adm_no' => $staff_id, 'school_code' => $school_code))->row_array();
            if (!empty($result)) {
                return $result['user_id'];
            } else {
                return -1;
            }
        }
    }

    public function GetStandardFromSection_id($dbObj, $Section_id) {
        $str = "SELECT standard,section FROM section_list WHERE id=" . $Section_id;
        $query = $dbObj->query($str)->result_array();
        $standard = $query[0]['standard'] . ' ' . $query[0]['section'];
        return $standard;
    }

    public function GetDeviceStatus($deviceId) {
        $deviceDetail = $this->db->get_where('app_device_list', array('device_uuid' => $deviceId))->row_array();
        if (!empty($deviceDetail)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getActiceClassStatus($dbObj, $section_id) {
        $dbObj->select('status');
        $status = $dbObj->get_where('section_list', array('id' => $section_id))->row_array();
        if ($status['status'] == 1) {
            return true;
        } else {
            return false;
        }
    }

}
