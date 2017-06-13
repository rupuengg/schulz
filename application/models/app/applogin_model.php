<?php

class applogin_model extends CI_Model {

    public function GetAllSchoolList() {
        $this->db->select('school_code,school_name,school_pic_path,school_web_url,brand_name,brand_url,brand_logo_path');
        $schoolList = $this->db->get('school_list')->result_array();
        return $schoolList;
    }

    public function GetDeviceRegisterStatus($dataObj) {
        $deviceDetail = $this->db->get_where('app_device_list', array('device_uuid' => $dataObj['device_uuid']))->row_array();
        if (!empty($deviceDetail)) {
            return printCustomMsg("FALSE", "Device Already Register", $deviceDetail['id']);
        } else {
            $insertArr = array('device_name' => $dataObj['device_name'], 'device_version' => $dataObj['device_version'], 'device_company' => $dataObj['device_company'], 'device_platform' => $dataObj['device_platform'], 'device_uuid' => $dataObj['device_uuid'], 'device_width' => $dataObj['device_width'], 'device_height' => $dataObj['device_height'], 'device_colordepth' => $dataObj['device_colordepth']);
            $this->db->insert('app_device_list', $insertArr);
            if ($this->db->insert_id()) {
                return printCustomMsg("TRUE", "Device Register Successfully", $this->db->insert_id());
            } else {
                return printCustomMsg("SAVEERROR", "Something was wrong,please try again", -1);
            }
        }
    }

    public function checkLoginDetail($dataObj) {
        include(APPPATH . 'config/database' . EXT);
        $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
        $systemDBObj = $this->load->database($webUserDsn, TRUE);
        $result = $systemDBObj->get_where('system_users', array('usrname' => $dataObj['username'], 'pass' => $dataObj['password'], 'member_type' => 'PARENT'))->row_array();

        if (isset($result['id'])) {
            $schoolDb = $systemDBObj->get_where('school_db_year_wise', array("school_code" => $result['school_code'], "current_db" => "YES"))->row_array();
            $schoolDetail = $systemDBObj->get_where('school_list', array("school_code" => $result['school_code']))->row_array();
            if (isset($schoolDb['db_name']) || $result['member_type'] == 'COMPANY') {
                $resultLogin = $systemDBObj->get_where('user_login_logs', array("user_id" => $result['id'], "login_person" => 'USER'))->row_array();
                if (isset($resultLogin['id'])) {
                    if ($result['login_activated'] == 'YES') {
                        if ($result['password_reset'] == 'NO') {
                            $dynamicDB = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
                            $dynamicDBObj = $this->load->database($dynamicDB, TRUE);

                            switch ($result['member_type']) {

                                case 'PARENT':

                                    $studentDetails = $systemDBObj->get_where('user_std_relation', array("user_id" => $result['id'], "school_code" => $result['school_code']))->result_array();
//print_r($studentDetails);                                  
// echo $result['id'];
//                                    exit();


                                    if (isset($studentDetails)) {
                                        $studentArr = array();
                                        $stdarray = array();
                                        $ii = 0;
                                        foreach ($studentDetails as $value) {
                                            $stdarray[$ii] = $value['adm_no'];
                                            $dynamicDBObj->select('a.adm_no,a.firstname,a.lastname,b.section,b.standard');
                                            $dynamicDBObj->from('biodata as a');
                                            $dynamicDBObj->join('section_list as b', 'a.section_id=b.id');
                                            $dynamicDBObj->where('a.adm_no', $value['adm_no']);
                                            $studArr = $dynamicDBObj->get()->row_array();
                                            $studentArr[$ii] = array('adm_no' => $studArr['adm_no'], 'name' => $studArr['firstname'] . ' ' . $studArr['lastname'], 'class' => $studArr['standard'] . $studArr['section'], 'profilePic' => base_url() . 'index.php/app/getstudphoto/' . $studArr['adm_no'] . '/THUMB');
                                            $ii++;
                                        }
                                        $userAccesskey = $this->InsertAccessKey($result['id'], $dataObj['device_id']);
                                        if ($userAccesskey == 'NOTREGISTERD') {
                                            return 'FALSE';
                                        }
                                        $finalArr = array('status' => 'TRUE', 'brand_url' => $schoolDetail['brand_url'], 'brand_name' => $schoolDetail['brand_name'], 'access_key' => $userAccesskey, 'child_list' => $studentArr, 'current_adm_no' => $studentArr[0]['adm_no'], 'userid' => $result['id']);
                                        //Insert a touple in login logs___    
                                        $dataLogin = array(
                                            'user_id' => $result['id'],
                                            'login_person' => $result['member_type'],
                                            'ip_info' => $_SERVER['REMOTE_ADDR'],
                                            'browser_info' => $_SERVER['HTTP_USER_AGENT']
                                        );
                                        $systemDBObj->insert('user_login_logs', $dataLogin);
                                        return $finalArr;
                                    } else {
                                        return 'NOSTUDENTFOUND';
                                    }

                                    break;
                                case 'STAFF':
                                    //Check wheter this staff id is available in school db or not?                                   

                                    $staffDetail = $dynamicDBObj->get_where('staff_details', array('id' => $result['staff_id']))->row_array();
                                    if (isset($staffDetail['id'])) {
                                        $myArray = array();
                                        $classTeacherRelation = $dynamicDBObj->get_where('section_list', array("class_teacher_id" => $result['staff_id']))->row_array();
                                        $myArray["logintype"] = "STAFF";
                                        $myArray["user_id"] = $result['id'];
                                        $myArray["database"] = $dynamicDB;
                                        if ($login_person_id == -1) { //normal user case
                                            if ($staffDetail['staff_type'] == 'DEO') {
                                                return 'DEOLOGIN';
//                                                $myArray["deo_staff_id"] = $result['staff_id'];
//                                                $myArray["deo_staff_name"] = $staffDetail['staff_fname'] . " " . $staffDetail['staff_lname'];
                                            } else {
                                                $myArray["deo_staff_id"] = -1;
                                                $myArray["deo_staff_name"] = 'NA';
                                            }
                                        } else {

                                            return 'DEOLOGIN';
//                                            $result_deo = $systemDBObj->get_where('system_users', array('id' => $login_person_id))->row_array();
//
//                                            $myArray["deo_staff_id"] = $result_deo['staff_id'];
//                                            $myArray["deo_staff_name"] = 'DEO KUMAR';
                                        }


                                        $myArray["staff_id"] = $result['staff_id'];
                                        $myArray["staff_name"] = $staffDetail['staff_fname'] . " " . $staffDetail['staff_lname'];
                                        $myArray["staff_desig"] = $staffDetail['staff_type'];
                                        $myArray["school_code"] = $schoolDetail['school_code'];
                                        $myArray["brand_name"] = $schoolDetail['brand_name'];
                                        $myArray["brand_logo"] = $schoolDetail['brand_logo_path'];
                                        if (isset($classTeacherRelation['id'])) {
                                            $myArray["is_staff_classteacher"] = 'YES';
                                            $myArray["staff_classteacher_section_id"] = $classTeacherRelation['id'];
                                            $myArray["staff_classteacher_class"] = $classTeacherRelation['standard'] . $classTeacherRelation['section'];
                                        }


//                                        $this->load->model('staff/staff_model', "staffModelObj");
//                                        $getMenu = $this->staffModelObj->getMenu($result['staff_id'], $dynamicDBObj);
//                                        $myArray['staffMenu'] = $getMenu;
                                        //  Insert a touple in login logs___
                                        $dataLogin = array(
                                            'user_id' => $result['id'],
                                            'login_person' => $login_person,
                                            'login_person_id' => $login_person_id,
                                            'ip_info' => $_SERVER['REMOTE_ADDR'],
                                            'browser_info' => $_SERVER['HTTP_USER_AGENT']
                                        );
                                        $systemDBObj->insert('user_login_logs', $dataLogin);

                                        return "TRUE";
                                    } else {
                                        return "FALSE";
                                    }
                                    break;
                                case 'STUDENT':
                                    break;
                                case 'COMPANY':
                                    //Insert a touple in login logs___
                                    $dataLogin = array(
                                        'user_id' => $result['id'],
                                        'login_person' => $login_person,
                                        'ip_info' => $_SERVER['REMOTE_ADDR'],
                                        'browser_info' => $_SERVER['HTTP_USER_AGENT']
                                    );
                                    $systemDBObj->insert('user_login_logs', $dataLogin);
                                    return "COMPANY";
                                    break;
                                default :
                                    break;
                            }
                        } else {
                            return "RESET";
                        }
                    } else {
                        return "DEACTIVATED";
                    }
                } else {
//                    $this->session->set_userdata(array("staff_id" => $result['staff_id']));
                    return "FIRSTTIMELOGIN";
                }
            } else { // If DB name not found
                return "DBNOTFOUND";
            }
        } else {
            return "MISMATCH";
        }
    }

    public function InsertAccessKey($userId, $deviceId) {
        $deviceRegisterStatus = $this->CheckDeviceRegister($deviceId);
        if ($deviceRegisterStatus != 'REGISTERD') {
            return 'NOTREGISTERD';
        } else {
            $accessKeyresult = $this->db->get_where('app_access_keys_details', array('device_id' => $deviceId, 'user_id' => $userId))->row_array();
            if (!empty($accessKeyresult)) {
                return $accessKeyresult['access_key'];
            } else {
                $myAccesskey = $this->GetMyAccesskey();
                $insertArr = array('device_id' => $deviceId, 'user_id' => $userId, 'access_key' => $myAccesskey, 'entry_by' => $userId);
                $this->db->insert('app_access_keys_details', $insertArr);
                if ($this->db->insert_id()) {
                    return $insertArr['access_key'];
                }
            }
        }
    }

    public function CheckDeviceRegister($deviceId) {
        $result = $this->db->get_where('app_device_list', array('device_uuid' => $deviceId))->row_array();
        if (!empty($result)) {
            return 'REGISTERD';
        } else {
            return 'NOTREGISTERD';
        }
    }

    public function GetMyAccesskey() {
        restart:
        $myRandomNumber = $this->GenrateAccesskey();
        $statusResult = $this->db->get_where('app_access_keys_details', array('access_key' => $myRandomNumber))->row_array();
        if (!empty($statusResult)) {
            goto restart;
        } else {
            return $myRandomNumber;
        }
    }

    public function GenrateAccesskey() {
        $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
        $QuantidadeCaracteres = strlen($Caracteres);
        $QuantidadeCaracteres--;
        $Hash = NULL;
        for ($x = 1; $x <= 64; $x++) {
            $Posicao = rand(0, $QuantidadeCaracteres);
            $Hash .= substr($Caracteres, $Posicao, 1);
        }
        return $Hash;
    }

    public function GetSchoolBrandUrl($schoolCode) {
        $schoolDetail = $this->db->get_where('school_list', array('school_code' => $schoolCode['school_code']))->row_array();
        return $schoolDetail;
    }

    public function getStaffPhoto($staffId, $type, $dataBase) {
        $dbObj = $this->load->database($dataBase, TRUE);
        $result = $dbObj->get_where('staff_details', array('id' => $staffId))->row_array();
        if ($result['id']) {
            if ($type == "THUMB") {
                return $result['profile_pic_path_thumbnail'];
            } else {
                return $result['profile_pic_path'];
            }
        } else {
            return false;
        }
    }

    public function GetStudentPhoto($adm_no, $type, $dataBase) {
        $dbObj = $this->load->database($dataBase, TRUE);
        $result = $dbObj->get_where('biodata', array('adm_no' => intval($adm_no)))->row_array();
        if (!empty($result)) {
            if ($type == "THUMB") {
                return $result['profile_pic_path_thumbnail'];
            } else {
                return $result['profile_pic_path'];
            }
        } else {
            return false;
        }
    }

    public function GetStudentDatabaseName($adm_no) {
        include(APPPATH . 'config/database' . EXT);
        $userIdResult = $this->db->get_where('user_std_relation', array('adm_no' => $adm_no))->row_array();
        if (!empty($userIdResult)) {
            $schoolDb = $this->db->get_where('school_db_year_wise', array("school_code" => $userIdResult['school_code'], "current_db" => "YES"))->row_array();
        } else {
            $schoolDb['db_name'] = 'merascho_demo';
        }

        $dynamicDB = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
        return $dynamicDB;
    }

    public function GetStaffDatabaseName($staff_id) {
        include(APPPATH . 'config/database' . EXT);
        $userIdResult = $this->db->get_where('system_users', array('staff_id' => $staff_id))->row_array();
        $schoolDb = $this->db->get_where('school_db_year_wise', array("school_code" => $userIdResult['school_code'], "current_db" => "YES"))->row_array();
        $dynamicDB = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
        return $dynamicDB;
    }

}
