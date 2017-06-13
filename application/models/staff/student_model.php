<?php

require_once (APPPATH . 'core/Barcode39.php');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class student_model extends CI_Model {

    public function getNewAdmNo() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select_max('adm_no');
        return $dbObj->get("biodata")->row_array();
    }

    public function getStudentBioData($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('adm_no', $adm_no);
        $ProfileData = $dbObj->get("biodata")->row_array();
        $ProfileData['profile_pic_path'] = base_url() . 'index.php/staff/getstudphoto/' . $adm_no . '/THUMB';
        $ProfileData['dob_date'] = date('d-m-Y', strtotime($ProfileData['dob_date']));
        $ProfileData['ad_date'] = date('d-m-Y', strtotime($ProfileData['ad_date']));
        return $ProfileData;
    }

    public function getStudentRelations($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $outputArr = array();
        $relationList = array("father", "mother", "brother", "sister", "other");
        $fieldlist = $dbObj->list_fields('gaurdian_details');
        $fieldlist = array_flip($fieldlist);
        $removeField = array('gg_id', 'g_notes', 'entry_by', 'deo_entry_by', 'timestemp');
        foreach ($removeField as $value) {
            unset($fieldlist[$value]);
        }
        $fieldlist = array_map(function() {
            
        }, $fieldlist);
        foreach ($relationList as $relation) {
            if ($relation == 'father' || $relation == 'mother') {
                $validation = 'required';
            } else {
                $validation = '';
            }
            $condition = array('adm_no' => $adm_no, 'relation' => $relation);
            $dbObj->select('adm_no, relation, g_name, g_quali, g_occp, g_desig, g_dept, g_office_add, g_home_add, g_mob, g_mail');
            $dbObj->where($condition);
            $relationData = $dbObj->get("gaurdian_details")->row_array();
            if ($relationData == NULL) {
                $fieldlist['adm_no'] = $adm_no;
                $fieldlist['relation'] = $relation;
                $fieldlist['g_name'] = '';
                $fieldlist['g_mob'] = '';
                $fieldlist['validation'] = $validation;
                $outputArr[] = $fieldlist;
            } else {
                $relationData['validation'] = $validation;
                $outputArr[] = $relationData;
            }
        }

        return $outputArr;
    }

    public function getStudentMedical($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('adm_no', $adm_no);
        $medicalDetails = $dbObj->get("medical_details")->row_array();
        if ($medicalDetails == NULL) {
            $medicalDetails['adm_no'] = $adm_no;
            return $medicalDetails;
        } else {
            return $medicalDetails;
        }
    }

    public function saveProfileData($ProfileData, $type, $school, $session) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $ProfileData = json_decode($ProfileData, TRUE);
        $filePath = 'files/' . $this->session->userdata('school_code') . '/' . $ProfileData['basicdata']['adm_no'] . '/';
        if ($type == 'NEW') {
            $ProfileData = $ProfileData['basicdata'];
            $dbObj->where('adm_no', $ProfileData['adm_no']);
            if ($dbObj->get("biodata")->row_array() == NULL) {
                if (isset($ProfileData['profile_pic_path'])) {
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0755, TRUE);
                    }
                    if (!copy($ProfileData['profile_pic_path'], $filePath . $ProfileData['adm_no'] . ".png")) {
                        echo 'not copy';
                        exit;
                    } else {
                        $dirPath = 'uploads/' . $ProfileData['adm_no'];
                        if (is_dir($dirPath)) {
                            if ($this->rmdir_recursive($dirPath)) {
                                $ProfileData['profile_pic_path'] = $filePath . $ProfileData['adm_no'] . ".png";
                                $ProfileData['profile_pic_path_thumbnail'] = $filePath . $ProfileData['adm_no'] . ".png";
                            } else {
                                echo 'no remove';
                                exit;
                            }
                        } else {
                            $ProfileData['profile_pic_path'] = '';
                            $ProfileData['profile_pic_path_thumbnail'] = '';
                        }
                    }
                }
                $ProfileData['entry_by'] = $this->session->userdata('staff_id');
                $ProfileData['deo_entry_by'] = $this->session->userdata('deo_staff_id');
                $ProfileData['dob_date'] = date('Y-m-d', strtotime($ProfileData['dob_date']));
                $ProfileData['ad_date'] = date('Y-m-d', strtotime($ProfileData['ad_date']));
                return $dbObj->insert('biodata', $ProfileData);
            } else {
                throw new Exception('Oops! Admission number already exist.');
            }
        } else {
            if ($ProfileData['basicdata']['profile_pic_path_thumbnail'] != '') {
                if (!is_dir($filePath)) {
                    mkdir($filePath, 0755, TRUE);
                }
                if (($ProfileData['basicdata']['profile_pic_path_thumbnail'] != $filePath . $ProfileData['basicdata']['adm_no'] . ".png") && ($ProfileData['basicdata']['profile_pic_path_thumbnail'] != $filePath . $ProfileData['basicdata']['adm_no'] . ".jpg")) {
                    if (!copy($ProfileData['basicdata']['profile_pic_path'], $filePath . $ProfileData['basicdata']['adm_no'] . ".png")) {
                        echo 'not copy';
                        exit;
                    } else {
                        $dirPath = 'uploads/' . $ProfileData['basicdata']['adm_no'];
                        if (is_dir($dirPath)) {
                            if ($this->rmdir_recursive($dirPath)) {
                                $ProfileData['basicdata']['profile_pic_path'] = $filePath . $ProfileData['basicdata']['adm_no'] . ".png";
                                $ProfileData['basicdata']['profile_pic_path_thumbnail'] = $filePath . $ProfileData['basicdata']['adm_no'] . ".png";
                            } else {
                                echo 'no remove';
                                exit;
                            }
                        } else {
                            $ProfileData['basicdata']['profile_pic_path'] = '';
                            $ProfileData['basicdata']['profile_pic_path_thumbnail'] = '';
                        }
                    }
                }
            }
            $adm_no = $ProfileData['basicdata']['adm_no'];
            $biodata = $ProfileData['basicdata'];
            $biodata['dob_date'] = date('Y-m-d', strtotime($biodata['dob_date']));
            $biodata['ad_date'] = date('Y-m-d', strtotime($biodata['ad_date']));

            $relations = $ProfileData['relations'];
            $medical = $ProfileData['medical'];
            unset($biodata['adm_no']);
            if (trim($adm_no) == '') {
                throw new Exception('Oops! Something went wrong.');
            } else {
                $condition = array("adm_no" => $adm_no);
                $dbObj->update('biodata', $biodata, $condition);
                $dbObj->where('adm_no', $adm_no);
                if ($dbObj->get("medical_details")->row_array() == NULL) {
                    $dbObj->insert('medical_details', $medical);
                } else {
                    unset($medical['adm_no']);
                    $dbObj->update('medical_details', $medical, $condition);
                }
                foreach ($relations as $relation) {
                    unset($relation['validation']);
                    $myinsrt[] = $relation;
                }
                $result = $dbObj->get_where("gaurdian_details", array('adm_no' => $adm_no))->result_array();
                if (!empty($result)) {
                    $dbObj->delete('gaurdian_details', array('adm_no' => $adm_no));
                    $dbObj->insert_batch('gaurdian_details', $myinsrt);
                } else {
                    $dbObj->insert_batch('gaurdian_details', $myinsrt);
                }
                if ($dbObj->affected_rows() < 0) {
                    return FALSE;
                } else {
                    return TRUE;
                }
            }
        }
    }

    /*     * ********************** Adarsh Module- student Profile page ************** */

    public function getStudentClassDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('section_id');
        $dbObj->where('adm_no =', $id);
        $dbObj->where('section_id !=', '-1');
        $output = $dbObj->get("biodata")->result_array();
        if (!empty($output)) {
            $dbObj->select('section,standard');
            $section = $dbObj->get_where("section_list", array('id' => $output[0]['section_id']))->result_array();
            $output[0]['section'] = $section[0]['section'];
            $output[0]['standard'] = $section[0]['standard'];
            $output = array_merge($output, $section);
            return $output[0];
        }
    }

    public function getStudentBlueCards($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $termDate = $this->getTermDate();
        $startsession = $termDate['startdate'];
        $end = $termDate['end'];
        $cardArray = array('BLUE', 'YELLOW', 'PINK', 'RED');
        $cardDetails = array();
        for ($k = 0; $k < count($cardArray); $k++) {
            $cardtype = $cardArray[$k];
            $query = "SELECT a.`card_type`,a.`adm_no`,a.`remarks`,a.`card_issue_date`,b.`staff_fname`,b.`staff_lname` FROM `cards_details` as a,`staff_details` as b WHERE a.`card_type` = '$cardtype' AND a.`adm_no` = '$id' AND b.`id` = a.`entry_by` AND DATE(a.`timestamp`) ORDER BY a.`timestamp`";
//            $query = "SELECT a.`card_type`,a.`adm_no`,a.`remarks`,a.`card_issue_date`,b.`staff_fname`,b.`staff_lname` FROM `cards_details` as a,`staff_details` as b WHERE a.`card_type` = '$cardtype' AND a.`adm_no` = '$id' AND b.`id` = a.`entry_by` AND DATE(a.`timestamp`) BETWEEN '$startsession' AND '$end' ORDER BY a.`timestamp`";
            $card[$cardtype] = $dbObj->query($query)->result_array();
            $cardDetails = array_merge($cardDetails, $card);
        }
        return $cardDetails;
    }

    public function getAllCards($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $termDate = $this->getTermDate();
        $startsession = $termDate['startdate'];
        $end = $termDate['end'];
        $query = "SELECT a.`card_type`,a.`adm_no`,a.`remarks`, DATE_FORMAT(a.`card_issue_date`, '%M %m, %Y') as date,DAYNAME(a.`card_issue_date`) as day,b.`staff_fname`,b.`staff_lname` FROM `cards_details` as a,`staff_details` as b WHERE a.`adm_no` = '$id' AND b.`id` = a.`entry_by` AND DATE(a.`timestamp`) BETWEEN '$startsession' AND '$end' ORDER BY a.`timestamp`";
        $card = $dbObj->query($query)->result_array();


        return $card;
    }

    public function getStudentSubject($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('student_subject_relation.subject_id,subject_list.subject_name');
        $dbObj->from('student_subject_relation');
        $dbObj->where('student_subject_relation.adm_no =', $id);
        $dbObj->join('subject_list', 'subject_list.id = student_subject_relation.subject_id');
        return $dbObj->get()->result_array();
    }

    public function getSubjectTeacher($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $subject = $this->getStudentSubject($id);
        $subjectDetails = array();
        for ($i = 0; $i < count($subject); $i++) {
            $subjectname = array();
            $sub_id = $subject[$i]['subject_id'];
            $query = "SELECT a.`staff_id`, CONCAT(b.`staff_fname`, b.`staff_lname`) as teacher FROM `subject_staff_relation` as a,`staff_details` as b WHERE `subject_id` = '$sub_id' AND a.`staff_id` != '-1' AND b.id =a.staff_id GROUP BY a.`timestamp` DESC LIMIT 1";
            $output = $dbObj->query($query)->result_array();
            if (!empty($output)) {
                $subjectDetails[] = array('subject_name' => $subject[$i]['subject_name'], 'teacher' => $output[0]['teacher'], 'staff_id' => $output[0]['staff_id']);
            } else {
                $subjectDetails[] = array('subject_name' => $subject[$i]['subject_name'], 'teacher' => 'Tacher Not Assign', 'staff_id' => $output[0]['staff_id']);
            }
        }
        return $subjectDetails;
    }

    public function getTermDate() {
        $currentYear = date('Y');
        $nextyear = date('Y', strtotime('+1 year'));
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $term = $dbObj->get("session_term_setting")->result_array();
        $dateArray = array();
        for ($i = 0; $i < count($term); $i++) {
            $endsession = array();
            if ($term[$i]['item'] == 'TERM1') {
                $endsession['startdate'] = $term[$i]['date_from'];
            } else {
                $endsession['end'] = $term[$i]['date_to'];
            }
            $dateArray = array_merge($dateArray, $endsession);
        }
        return $dateArray;
    }

    public function getStudentAbsentDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $termDate = $this->getTermDate();
        $startsession = $termDate['startdate'];
        $end = $termDate['end'];
        $query = "SELECT reason,DATE_FORMAT(attendance_date, '%M %m, %Y') as date,DAYNAME(attendance_date) as day FROM (`attendance_detail`) WHERE `att_status` = 'ABSENT' AND `adm_no` = '$id' AND DATE(timestamp) BETWEEN  '$startsession'AND '$end' ORDER By `timestamp`";
        $output = $dbObj->query($query)->result_array();
        return $output;
    }

    public function getStudentLateDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $termDate = $this->getTermDate();
        $startsession = $termDate['startdate'];
        $end = $termDate['end'];
        $query = "SELECT reason,DATE_FORMAT(attendance_date, '%M %m, %Y') as date,DAYNAME(attendance_date) as day FROM (`attendance_detail`) WHERE `att_status` = 'EXP' AND `adm_no` = '$id' AND DATE(timestamp) BETWEEN  '$startsession'AND '$end' ORDER BY `timestamp`";
        $output = $dbObj->query($query)->result_array();
        return $output;
    }

    public function issuecards() {
        $issudate = date('Y-m-d');
        $json = json_decode($this->input->post('data'), TRUE);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data_insert = array(
            'adm_no' => $json['adm_no'],
            'remarks' => $json['todoname'],
            'card_issue_date' => $issudate,
            'card_type' => strtoupper($json['card_type']),
            'entry_by' => $json['entryby']
        );
        $dbObj->insert('cards_details', $data_insert);
        return TRUE;
    }

    public function GetStudentPhoto($adm_no, $type) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $result = $dbObj->get_where('biodata', array('adm_no' => $adm_no))->row_array();
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

    public function rmdir_recursive($dir) {

        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file)
                continue;
            if (is_dir("$dir/$file"))
                rmdir_recursive("$dir/$file");
            else
                unlink("$dir/$file");
        }
        if (rmdir($dir)) {
            return true;
        } else {
            false;
        }
    }

//*************************************Student id cards(SAPNA)***************//
    public function idCardDetails($sec_id, $adm_no, $dbName = NULL) {
        if (!$this->session->userdata('logintype')) {
            $dbName = $dbName;
        } else {
            $dbName = $this->session->userdata('database');
        }
        $dbObj = $this->load->database($dbName, TRUE);
//          echo $dbObj;exit;
//        $dbObj = 'mysqli://root:root@localhost/merascho_demo';
        if ($adm_no !== NULL) {
            $where = array('a.adm_no' => $adm_no);
        } else {
            $where = array('a.section_id' => $sec_id);
        }
        $dbObj->select("CONCAT(a.firstname,' ',a.lastname) as stud_name, a.adm_no,CONCAT(c.standard,' ',c.section) as class,CONCAT(a.address1,' ', a.address2,',', a.city,',', a.state,',',a.pin_code,',', a.country) as address,a.mobile_no_for_sms as contact_no,a.profile_pic_path as stud_pic", false);
        $dbObj->join('section_list as c', 'c.id=a.section_id', 'left');
        $res = $dbObj->get_where('biodata as a', $where)->result_array();
        $idcard_schoolinfo = $this->idcard_schoolinfo($dbObj);
        foreach ($res as $key => $val) {
            $res[$key]['g_name'] = $this->getgaurdianDetail($val['adm_no'], "father", $dbObj);
            $res[$key]['stud_name'] = ucwords(strtolower($res[$key]['stud_name']));
            $res[$key]['g_name'] = ucwords(strtolower($res[$key]['g_name']));
            $res[$key]['address'] = ucwords(strtolower($res[$key]['address']));
            $res[$key]['idcard'] = $this->load->view('template/ID_Card.php', array('schoolinfo' => $idcard_schoolinfo, 'idcardinfo' => $res[$key]), TRUE);
        }
        return $res;
    }

    public function idcard_schoolinfo($dbObj) {
        $dbObj->select('school_name,school_address,school_phone,email_id,school_logo_path');
        $dbObj->from('school_setting');
        $result = $dbObj->get()->row_array();
        return $result;
    }

    /*     * ************************studentsummary(sapna)************************ */

    public function GetStudentsummaryDetail($last_id = 0) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("CONCAT(a.firstname,' ',a.lastname) as stud_name, a.adm_no,CONCAT(c.standard,' ',c.section) as class,CONCAT(a.address1,',', a.city,',', a.state,',',a.pin_code,',', a.country) as address,a.mobile_no_for_sms as contact_no,a.profile_pic_path as stud_pic,a.sex,a.e_mail,a.dob_date,a.ad_date,a.roll_no,a.house", false);
        $dbObj->join('section_list as c', 'c.id=a.section_id', 'left');
        $dbObj->limit(100);
        $res = $dbObj->get_where('biodata as a', array('a.adm_no > ' => $last_id))->result_array();
       foreach ($res as $key => $val) {
            $res[$key]['g_name'] = $this->getgaurdianDetail($val['adm_no'], "father", $dbObj);
            $res[$key]['stud_name'] = ucwords(strtolower($res[$key]['stud_name']));
            $res[$key]['g_name'] = ucwords(strtolower($res[$key]['g_name']));
            $res[$key]['address'] = ucwords(strtolower($res[$key]['address']));
            $res[$key]['address'] = ucwords(strtolower($res[$key]['address']));
            $res[$key]['class'] = $res[$key]['class'];
        }
        return $res;
    }

    public function getgaurdianDetail($adm, $rel, $dbObj) {
        $dbObj->select('g_name');
        $result = $dbObj->get_where('gaurdian_details', array('relation' => $rel, 'adm_no' => $adm))->row_array();
        if (!empty($result)) {
            return $result['g_name'];
        } else {
            return '-';
        }
    }

    public function getclassTeacher($sec_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("CONCAT(a.salutation,'',a.staff_fname, ' ',a.staff_lname ) as teacher", FALSE);
        $dbObj->from('staff_details as a');
        $dbObj->join('section_list as b', 'a.id=b.class_teacher_id');
        $dbObj->where('b.id', $sec_id);
        $classteacher = $dbObj->get()->row_array();
        if (!empty($classteacher)) {
            return $classteacher['teacher'];
        } else {
            return $classteacher;
        }
    }

}
