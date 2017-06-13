<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_model extends CI_Model {

    public function SuperLogin($user_id, $login_person, $login_person_id) {
        include(APPPATH . 'config/database' . EXT);
        $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
        $systemDBObj = $this->load->database($webUserDsn, TRUE);
        $systemDBObj->select('usrname as username,pass as password');
        $data = $systemDBObj->get_where('system_users', array('id' => $user_id))->row_array();
        if (!empty($data)) {


            $result = $this->checkLoginDetail($data, $login_person, $login_person_id);
            if ($result == 'TRUE') {
                return $result;
            } else {
                return $result;
            }
        } else {
            return $data = -1;
        }
    }

    public function checkLoginDetail($data, $login_person, $login_person_id) {
        include(APPPATH . 'config/database' . EXT);
        $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
        $systemDBObj = $this->load->database($webUserDsn, TRUE);

        $result = $systemDBObj->get_where('system_users', array('usrname' => $data['username'], 'pass' => $data['password']))->row_array();
        if (isset($result['id'])) {
            $schoolDb = $systemDBObj->get_where('school_db_year_wise', array("school_code" => $result['school_code'], "current_db" => "YES"))->row_array();
            $schoolDetail = $systemDBObj->get_where('school_list', array("school_code" => $result['school_code']))->row_array();

            if (isset($schoolDb['db_name']) || $result['member_type'] == 'COMPANY') {
                $resultLogin = $systemDBObj->get_where('user_login_logs', array("user_id" => $result['id'], "login_person" => 'USER'))->row_array();
                if (isset($resultLogin['id']) || $login_person_id > 0) {
                    if ($result['login_activated'] == 'YES' || $login_person_id > 0) {
                        if ($result['password_reset'] == 'NO' || $login_person_id > 0) {
                            $dynamicDB = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
                            $dynamicDBObj = $this->load->database($dynamicDB, TRUE);

                            switch ($result['member_type']) {

                                case 'PARENT':

                                    $studentDetails = $systemDBObj->get_where('user_std_relation', array("user_id" => $result['id'], "school_code" => $result['school_code']))->result_array();
//print_r($studentDetails);                                  
// echo $result['id'];
                                    // exit();
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
                                            $studentArr[$ii] = $studArr;
                                            $ii++;
                                        }
                                        // echo($stdarray[0]);
                                        //exit();
                                        $sessionArr = array(
                                            "logintype" => "PARENT",
                                            "user_id" => $result['id'],
                                            "database" => $dynamicDB,
                                            "adm_no_list" => $stdarray,
                                            "childList" => $studentArr,
                                            "current_adm_no" => $stdarray[0],
                                            "brand_name" => $schoolDetail['brand_name']
                                        );
                                        //Insert a touple in login logs___    
                                        $dataLogin = array(
                                            'user_id' => $result['id'],
                                            'login_person' => $login_person,
                                            'ip_info' => $_SERVER['REMOTE_ADDR'],
                                            'browser_info' => $_SERVER['HTTP_USER_AGENT']
                                        );
                                        $systemDBObj->insert('user_login_logs', $dataLogin);
                                        $this->session->set_userdata($sessionArr);
                                        return "TRUE";
                                    } else {
                                        return 'NOSTUDENTFOUND';
                                    }

                                    break;
                                case 'STAFF':
                                    //Check wheter this staff id is available in school db or not?                                   

                                    $staffDetail = $dynamicDBObj->get_where('staff_details', array('id' => $result['staff_id']))->row_array();
                                    if (isset($staffDetail['id'])) {
                                        $myArray = array();

                                        $classTeacherRelation = $dynamicDBObj->get_where('section_list', array("class_teacher_id" => $result['staff_id'], 'status' => 1))->row_array();
                                        $myArray["logintype"] = "STAFF";
                                        $myArray["user_id"] = $result['id'];
                                        $myArray["database"] = $dynamicDB;
                                        if ($login_person_id == -1) { //normal user case
                                            if ($staffDetail['staff_type'] == 'DEO') {
                                                $myArray["deo_staff_id"] = $result['staff_id'];
                                                $myArray["deo_staff_name"] = $staffDetail['staff_fname'] . " " . $staffDetail['staff_lname'];
                                            } else {
                                                $myArray["deo_staff_id"] = -1;
                                                $myArray["deo_staff_name"] = 'NA';
                                            }
                                        } else {
                                            $result_deo = $systemDBObj->get_where('system_users', array('id' => $login_person_id))->row_array();

                                            $myArray["deo_staff_id"] = $result_deo['staff_id'];
                                            $myArray["deo_staff_name"] = 'DEO KUMAR';
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
                                        $this->load->model('staff/staff_model', "staffModelObj");
                                        $getMenu = $this->staffModelObj->getMenu($result['staff_id'], $dynamicDBObj);
                                        if ($staffDetail['staff_type'] == 'ACCOUNT' || $staffDetail['staff_type'] == 'LIBRARIAN') {
                                            unset($getMenu[0]);
                                            $getMenu = array_values($getMenu);
                                        }

                                        $myArray['staffMenu'] = $getMenu;
                                        //  Insert a touple in login logs___
                                        $dataLogin = array(
                                            'user_id' => $result['id'],
                                            'login_person' => $login_person,
                                            'login_person_id' => $login_person_id,
                                            'ip_info' => $_SERVER['REMOTE_ADDR'],
                                            'browser_info' => $_SERVER['HTTP_USER_AGENT']
                                        );
                                        $systemDBObj->insert('user_login_logs', $dataLogin);
                                        $this->session->set_userdata($myArray);
                                        return "TRUE";
                                    } else {
                                        return "FALSE";
                                    }
                                    break;
                                case 'STUDENT':
                                    break;
                                case 'COMPANY':

                                    $this->session->set_userdata(array("logintype" => "COMPANY"));
                                    $this->session->set_userdata(array("company_staff_id" => $result['staff_id']));
                                    $this->session->set_userdata(array("user_id" => $result['id']));

                                    $companyStaffDetail = $systemDBObj->get_where('company_staff_details', array("id" => $result['staff_id']))->row_array();
                                    $this->session->set_userdata(array("staff_rm_id" => $companyStaffDetail['rm_id']));
                                    $this->session->set_userdata(array("admin_type" => $companyStaffDetail['admin_type']));

                                    $this->session->set_userdata(array("company_staff_id" => $result['staff_id']));

                                    $this->session->set_userdata(array("company_staff_name" => $companyStaffDetail['name']));

                                    //  $this->session->set_userdata(array("company_staff_designation" => $companyStaffDetail['designation']));
//echo '22';
                                    //   exit();
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
                    $this->session->set_userdata(array("staff_id" => $result['staff_id']));
                    return "FIRSTTIMELOGIN";
                }
            } else { // If DB name not found
                return "DBNOTFOUND";
            }
        } else {
            return "MISMATCH";
        }
    }

    public function changeidpassword($arrData) {
        $data = json_decode($arrData, true);
        $oldUsername = $data['currentuser'];
        $oldpassword = $data['currentpassword'];
        $newUsername = $data['newuser'];
        $newpassword1 = $data['newpass'];
        $newpassword2 = $data['repasword'];

        if ($newpassword1 != $newpassword2) {
            return 'NEW_PASSWORD_MISMATCH';
        }
        $this->db->select('id');
        $validateoldlogin = $this->db->get_where("system_users", array('usrname' => $oldUsername, 'pass' => $oldpassword))->result_array();
        if (!empty($validateoldlogin)) {
            $user_id = $validateoldlogin[0]['id'];
            $username = $this->db->get_where("system_users", array('usrname' => $newUsername))->result_array();
            if (empty($username)) {
                ///ALL IS WELL CASE- change its login id as password
                $dataInsert = array(
                    'usrname' => $newUsername,
                    'pass' => $newpassword1
                );
                $dataLogin = array(
                    'user_id' => $user_id,
                    'login_person' => 'USER',
                    'login_person_id' => '-2',
                    'ip_info' => $_SERVER['REMOTE_ADDR'],
                    'browser_info' => $_SERVER['HTTP_USER_AGENT']
                );
                $this->db->where('id', $user_id);
                if ($this->db->update('system_users', $dataInsert)) {
                    $this->db->insert('user_login_logs', $dataLogin);
                    return "TRUE";
                } else {
                    return "DB_ENTRY_WRONG";
                }
            } else {
                return 'USER_NAME_NOT_AVAILABLE';
            }
        } else {
            return 'WRONG_OLD_ID_PASSWORD';
        }
    }

    public function resetPassword($arrPassword) {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('id');
        $this->db->from('system_users');
        $this->db->where(array('id' => $user_id, 'pass' => $arrPassword['oldpassword']));
        $query = $this->db->get()->row_array();
        if (!empty($query)) {
            if ($query['id'] == $this->session->userdata('user_id')) {
                $data = array(
                    'pass' => $arrPassword['newpassword']
                );
                $this->db->where('id', $this->session->userdata('user_id'));
                if ($this->db->update('system_users', $data)) {
                    return "TRUE";
                } else {
                    return "WRONG";
                }
            } else {
                return "WRONG";
            }
        } else {
            return "FALSE";
        }
    }

    public function checkLogin($id) {
        $this->db->select('user_id');
        $username = $this->db->get_where("user_login_logs", array('user_id' => $id))->result_array();
        if (count($username) > 0) {
            return $username[0]['user_id'];
        } else {
            return 'NA';
        }
    }

}
