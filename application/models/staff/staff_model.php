<?php

class staff_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model("core/core", "coreObj");
    }

    public function getStaffDetail($id) {
        $result = array();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($id == "ALL") {
            $dbObj->select('id,salutation,staff_fname,staff_lname,profile_pic_path,mobile_no_for_sms,staff_landline,staff_add,department,designation,qualification,experience,date_of_joining,e_mail,dob_date,extra_skills');
            $result = $dbObj->get_where("staff_details", array('show_in_portal' => "YES"))->result_array();
        } else {
            $dbObj->select('id,salutation,staff_fname,staff_lname,profile_pic_path,mobile_no_for_sms,staff_landline,staff_add,department,designation,qualification,experience,date_of_joining,e_mail,dob_date,extra_skills');
            $result = $dbObj->get_where("staff_details", array('show_in_portal' => "YES", 'id' => $id))->result_array();
        }
        if (!empty($result)) {
            for ($i = 0; $i < count($result); $i++) {
                $className = $this->getStaffClassTeacherStatus($dbObj, $result[$i]['id']);
                $result[$i]['classTeach'] = $className;
                $result[$i]['profile_pic_path'] = base_url() . 'index.php/staff/getphoto/' . $result[$i]['id'] . '/THUMB';
                $result[$i]['dob_date'] = date('d-m-Y', strtotime($result[$i]['dob_date']));
                $result[$i]['date_of_joining'] = date('d-m-Y', strtotime($result[$i]['date_of_joining']));
            }
        }
        return $result;
    }

    public function getStaffClassTeacherStatus($dbObj, $staffId) {
        $result = $dbObj->get_where('section_list', array('class_teacher_id' => $staffId, 'status' => 1))->row_array();
        if (!empty($result)) {
            return $result['standard'] . $result['section'];
        } else {
            return -1;
        }
    }

    public function getMenu($staffId, $db) {
        $dbObj = $db;
        $myFinalResult = array();
        //Get staff Child Menu

        $tempStaffMenus = $dbObj->get_where('staff_menu_staff_relation', array('staff_id' => $staffId, "status" => "TRUE"))->result_array();
        $defaultMenus = $dbObj->get_where('staff_menu_child_list', array("default" => "YES"))->result_array();
        if (count($tempStaffMenus) > 0) {
            foreach ($tempStaffMenus as $value) {
                $staffMenus[] = $value['child_id'];
            }
        }
        if (count($defaultMenus) > 0) {
            foreach ($defaultMenus as $value) {
                $staffMenus[] = $value['childid'];
            }
        }
        $staffMenus = array_unique($staffMenus);
        //GetAll Main Menu
        $dbObj->select('*');
        $dbObj->order_by("priority", "asc");
        $myResult = $dbObj->get('staff_main_menu_list')->result_array();
        if (count($myResult) > 0) {
            foreach ($myResult as $value) {
                //fetch one by one child menu of selected main menu
                $allChildMenus = $dbObj->get_where('staff_menu_child_list', array("main_menu_id" => $value['menuid']))->result_array();
                if (count($allChildMenus) > 0) {
                    for ($i = 0; $i < count($allChildMenus); $i++) {
                        if (in_array($allChildMenus[$i]['childid'], $staffMenus)) {
                            $allChildMenus[$i]['selected'] = true;
                        } else if ($allChildMenus[$i]['default'] == "YES") {
                            $allChildMenus[$i]['selected'] = true;
                        } else {
                            $allChildMenus[$i]['selected'] = false;
                        }
                    }
                }
                $myFinalResult[] = array("menuid" => $value['menuid'], "menuname" => $value['menucaption'], "class" => $value['class'], "childDetail" => $allChildMenus);
            }
        }
        // print_r($myFinalResult);
        return $myFinalResult;
    }

    public function saveUpdateStaffDetail($myArr, $randomnum) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $myArr['dob_date'] = date('Y-m-d', strtotime($myArr['dob_date']));
        $myArr['date_of_joining'] = date('Y-m-d', strtotime($myArr['date_of_joining']));
        if (date('Y-m-d', strtotime($myArr['date_of_joining'])) > date('Y-m-d')) {
            return 'DOJ';
        } else if (date('Y', strtotime($myArr['dob_date'])) > date('Y') - 10) {
            return 'DOB';
        } else {
            $tempath = 'uploads/' . $randomnum;
            $this->load->model('staff/student_model', 'stumodelObj');
            if (!isset($myArr['id']) || $myArr['id'] == '') {
                $dbObj->insert('staff_details', $myArr);
                if ($dbObj->affected_rows() == 0) {
                    return - 1;
                } else {
                    $id = $dbObj->insert_id();
                    if (isset($myArr['profile_pic_path'])) {
                        $filePath = 'files/' . $this->session->userdata('school_code') . '/STAFF/' . $id . '/';
                        if (!is_dir($filePath)) {
                            mkdir($filePath, 0755, TRUE);
                        }
                        if (!copy($myArr['profile_pic_path'], $filePath . $id . ".png")) {
                            echo 'Not Copied';
                            exit;
                        } else {
                            if ($this->stumodelObj->rmdir_recursive($tempath)) {
                                $data['profile_pic_path'] = $filePath . $id . ".png";
                                $data['profile_pic_path_thumbnail'] = $filePath . $id . ".png";
                                $dbObj->where('id', $id);
                                $dbObj->update('staff_details', $data);
                                if ($dbObj->affected_rows() == 0) {
                                    return -1;
                                } else {
                                    return array('id' => $id, 'path' => base_url() . 'index.php/staff/getphoto/' . $id . '/THUMB');
//                            return $id;
                                }
                            } else {
                                echo 'no remove';
                                exit;
                            }
                        }
                    } else {
                        return array('id' => $id, 'path' => base_url() . 'index.php/staff/getphoto/' . $id . '/THUMB');
                    }
                }
            } else {
                $filePath = 'files/' . $this->session->userdata('school_code') . '/STAFF/' . $myArr['id'] . '/';
                $filename = time() . $myArr['id'] . ".png";
                if (!is_dir($filePath)) {
                    mkdir($filePath, 0755, TRUE);
                }
                if (is_dir($tempath)) {
                    if (!copy($myArr['profile_pic_path'], $filePath . $filename)) {
                        echo 'Not Copied';
                        exit;
                    } else {
                        if ($this->stumodelObj->rmdir_recursive($tempath)) {
                            unset($myArr['classTeach']);
                            $myArr['profile_pic_path'] = $filePath . $filename;
                            $myArr['profile_pic_path_thumbnail'] = $filePath . $filename;
                            $dbObj->where('id', $myArr['id']);
                            $dbObj->update('staff_details', $myArr);
                            if ($dbObj->affected_rows() > 0) {
                                return array('id' => $myArr['id'], 'path' => $myArr['profile_pic_path_thumbnail']);
                            } else {
                                return -1;
                            }
                        } else {
                            echo 'no remove';
                            exit;
                        }
                    }
                } else {
                    unset($myArr['classTeach']);
                    $dbObj->where('id', $myArr['id']);
                    $dbObj->update('staff_details', $myArr);
                    if ($dbObj->affected_rows() == 0) {
                        return -1;
                    } else {
                        return $myArr['id'];
                    }
                }
            }
        }
    }

    public function saveStaffPrivilege($myArr) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $myInsertArray = array();
        foreach ($myArr['menuDetail'] as $value) {
            foreach ($value['childDetail'] as $myVal) {
                if ($myVal['selected']) {
                    $myInsertArray[] = array("staff_id" => $myArr['id'], "child_id" => $myVal['childid']);
                }
            }
        }
        if (count($myInsertArray) > 0) {
            $dbObj->where('staff_id', $myArr['id']);
            $dbObj->update('staff_menu_staff_relation', array("status" => "FALSE"));
            $dbObj->insert_batch("staff_menu_staff_relation", $myInsertArray);
            return true;
        } else {
            return false;
        }
    }

    public function getStaffPhoto($staffId, $type) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $result = $dbObj->get_where('staff_details', array('id' => $staffId))->row_array();
        if (isset($result['id'])) {
            if ($type == "THUMB") {
                return $result['profile_pic_path_thumbnail'];
            } else {
                return $result['profile_pic_path'];
            }
        } else {
            return false;
        }
    }

    public function getAllDepartment() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,name');
        return $dbObj->get("department")->result_array();
    }

    public function getAllDesignation() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,name');
        return $dbObj->get("designation")->result_array();
    }

    /*     * **************** Adarsh Module- Staff Profile Page ********************* */

    public function getStaffDesignation($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('department as depart,designation as desig');
        $output = $dbObj->get_where("staff_details", array('id' => $id))->result_array();
        $dataArray = array();
        for ($k = 0; $k < count($output); $k++) {
            $detailArray = array();
            $department = $output[$k]['depart'];
            $designation = $output[$k]['desig'];
            if ($department == 0 && $designation == 0) {
                $detailArray[0]['designation'] = 'Designation not assign';
                $detailArray[0]['department'] = 'Department not assign';
            } else if ($department != 0 && $designation == 0) {
                $dbObj->select('name as department');
                $depart = $dbObj->get_where("department", array('id' => $department))->result_array();
                $department = $depart[0]['department'];
                $depart[0]['designation'] = 'Designation not assign';
                $depart[0]['department'] = $department;
                $detailArray = array_merge($detailArray, $depart);
            } else if ($department == 0 && $designation != 0) {
                $dbObj->select('name as designation');
                $desig = $dbObj->get_where("designation", array('id' => $designation))->result_array();

                $designation = $desig[0]['designation'];
                $desig[0]['department'] = 'Department not assign';
                $desig[0]['designation'] = $designation;
                $detailArray = array_merge($detailArray, $desig);
            } else if ($department != 0 && $designation != 0) {
                $dbObj->select('name as designation');
                $desig = $dbObj->get_where("designation", array('id' => $designation))->result_array();
                $dbObj->select('name as department');
                $depart = $dbObj->get_where("department", array('id' => $department))->result_array();
                $designation = $desig[0]['designation'];
                $department = $depart[0]['department'];
//                $mergeArray = array_merge($designation, $department);
//                $desig[0]['department'] = 'Department not assign';
                $combo[0]['department'] = $department;
                $combo[0]['designation'] = $designation;

                $detailArray = array_merge($detailArray, $combo);
//                $dbObj->select('staff_details.id,staff_details.staff_fname as fname,staff_details.staff_lname as lname,staff_details.qualification,staff_details.date_of_joining,staff_details.dob_date,staff_details.experience,staff_details.extra_skills,staff_details.staff_add,staff_details.mobile_no_for_sms,staff_details.staff_landline, designation.name as designation,department.name as department');
//                $dbObj->from('staff_details');
//                $dbObj->where('staff_details.id=', $id);
//                $dbObj->join('department', 'department.id' = $department);
//                $dbObj->join('designation', 'designation.id = staff_details.designation');
//                $allDetails = $dbObj->get()->result_array();
//                $detailArray = array_merge($detailArray, $allDetails);
            }
            $dataArray = $detailArray;
        }
        return $dataArray[0];
    }

    public function getClassTeacherDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('standard,section');
        return $dbObj->get_where("section_list", array('class_teacher_id' => $id))->result_array();
    }

    public function getClassTeacherSubject($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.subject_id,a.section_id');
        $dbObj->from('subject_staff_relation as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.staff_id', $id);
        $dbObj->where('b.status', 1);
        $teacher = $dbObj->get()->result_array();
        $section = array();
        for ($i = 0; $i < count($teacher); $i++) {
            $section_id = $teacher[$i]['section_id'];
            $subject_id = $teacher[$i]['subject_id'];
            $dbObj->select('standard,section');
            $sectionname = $dbObj->get_where("section_list", array('id' => $section_id))->result_array();
            $dbObj->select('subject_name');
            $subjectname = $dbObj->get_where("subject_list", array('id' => $subject_id))->result_array();
            $sectionname[0]['sbject'] = $subjectname[0]['subject_name'];
            $section = array_merge($section, $sectionname);
        }

        return $section;
    }

    public function geteventIncharge($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,name,on_date,event_end_date,venue');
        $event = $dbObj->get_where("event_details", array('incharge_staff_id' => $id))->result_array();
        $staffeventArray = array();
        if (!empty($event)) {
            for ($i = 0; $i < count($event); $i++) {
                $dataArray = array();
                $event_id = $event[$i]['id'];
                $team = $this->geteventTeam($event_id);
                $staff = $this->geteventStaffVolunteer($event_id);
                $student = $this->geteventStudentVolunteer($event_id);
                $dataArray[0]['id'] = $event[0]['id'];
                $dataArray[0]['name'] = $event[0]['name'];
                $dataArray[0]['on_date'] = $event[0]['on_date'];
                $dataArray[0]['event_end_date'] = $event[0]['event_end_date'];
                $dataArray[0]['venue'] = $event[0]['venue'];
                $dataArray[0]['team'] = $team[0]['team'];
                $dataArray[0]['member'] = $team[0]['member'];
                $dataArray[0]['volunteer'] = $staff[0]['staffvolunteer'] + $student[0]['studentvolunteer'];
                $staffeventArray = array_merge($staffeventArray, $dataArray);
            }
        }

        return $staffeventArray;
    }

    public function geteventVolunteer($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('event_id');
        $event = $dbObj->get_where("event_volunteer_staff", array('volunteer_staff_id' => $id))->result_array();
        $staffeventArray = array();
        if (!empty($event)) {
            for ($i = 0; $i < count($event); $i++) {
                $event_id = $event[$i]['event_id'];
                $team = $this->geteventTeam($event_id);
                $eventDetails = $this->geteventDetails($event_id);
                if (!empty($eventDetails)) {
                    $eventincharge = $this->getTotalEventIncharge($event_id);
                    $event[$i]['team'] = $team[0]['team'];
                    $event[$i]['member'] = $team[0]['member'];
                    $event[$i]['incharge'] = $eventincharge[0]['incharge'];
                    $event[$i]['name'] = $eventDetails[0]['name'];
                    $event[$i]['on_date'] = $eventDetails[0]['on_date'];
                    $event[$i]['event_end_date'] = $eventDetails[0]['event_end_date'];
                    $event[$i]['venue'] = $eventDetails[0]['venue'];
                    $staffeventArray = array_merge($staffeventArray, $event);
                }
            }
        }

        return $staffeventArray;
    }

    public function getTotalEventIncharge($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as incharge');
        return $dbObj->get_where("event_details", array('id' => $id))->result_array();
    }

    public function geteventTeam($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as team, id');
        $team = $dbObj->get_where("event_team_detail", array('event_id' => $id))->result_array();
        $memberArray = array();
        for ($i = 0; $i < count($team); $i++) {
            $team_id = $team[$i]['id'];
            $member = $this->geteventMember($team_id);
            $member[0]['team'] = $team[0]['team'];
            $memberArray = array_merge($memberArray, $member);
        }
        return $memberArray;
    }

    public function geteventDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,name,on_date,event_end_date,venue');
        return $dbObj->get_where("event_details", array('id' => $id))->result_array();
    }

    public function geteventMember($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as member');
        return $dbObj->get_where("event_team_member", array('team_id' => $id))->result_array();
    }

    public function geteventStaffVolunteer($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as staffvolunteer');
        return $dbObj->get_where("event_volunteer_staff", array('event_id' => $id))->result_array();
    }

    public function geteventStudentVolunteer($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as studentvolunteer');
        return $dbObj->get_where("event_volunteer_student", array('event_id' => $id))->result_array();
    }

    /*     * ******************* Staff Dashboard Model *************** */

    public function getBirthday() {
        $todaydate = date('Y-m-d');
        $nexttendate = date('Y-m-d', strtotime('+45 day', strtotime($todaydate)));
        $nextday = date("d-m", strtotime('+1 day', strtotime($todaydate)));
        $currentday = date("d-m", strtotime($todaydate));
        $birthdayarray = array();
        while ($todaydate < $nexttendate) {
            $month = date("m", strtotime($todaydate));
            $day = date("d", strtotime($todaydate));
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $studenttemarray = array();
            $stafftemarray = array();
            $dbObj->select('adm_no,firstname,lastname,dob_date,profile_pic_path');
            $dbObj->where('MONTH(dob_date)', $month);
            $dbObj->where('DAY(dob_date)', $day);
            $dbObj->where('section_id > ', 0);
            $studentbirthdayarray = $dbObj->get('biodata')->row_array();
            if (!empty($studentbirthdayarray)) {
                $month_day = date("d-m", strtotime($studentbirthdayarray['dob_date']));
                if ($currentday == $month_day) {
                    $studentbirthdayarray['day'] = 'Today';
                } elseif ($nextday == $month_day) {
                    $studentbirthdayarray['day'] = 'Tommorrow';
                } else {
                    $studentbirthdayarray['day'] = date('jS M', strtotime($month_day . '-' . date('Y')));
                }
                $studentbirthdayarray['type'] = 'STUDENT';
                $studenttemarray = array_merge($studenttemarray, $studentbirthdayarray);
            }
            $dbObj->select('id,staff_fname as firstname,staff_lname as lastname,dob_date,profile_pic_path');
            $dbObj->where('MONTH(dob_date)', $month);
            $dbObj->where('DAY(dob_date)', $day);
            $staffbirthdayarray = $dbObj->get('staff_details')->row_array();
            if (!empty($staffbirthdayarray)) {
                $month_day = date("d-m", strtotime($staffbirthdayarray['dob_date']));
                if ($currentday == $month_day) {
                    $staffbirthdayarray['day'] = 'Today';
                } elseif ($nextday == $month_day) {
                    $staffbirthdayarray['day'] = 'Tommorrow';
                } else {
                    $staffbirthdayarray['day'] = date('jS M', strtotime($month_day . '-' . date('Y')));
                }
                $staffbirthdayarray['type'] = 'STAFF';
                $stafftemarray = array_merge($stafftemarray, $staffbirthdayarray);
            }
            if (!empty($studenttemarray)) {
                $birthdayarray[] = $studenttemarray;
            }
            if (!empty($stafftemarray)) {
                $birthdayarray[] = $stafftemarray;
            }
            $todaydate = date('Y-m-d', strtotime($todaydate . ' + 1 days'));
        }
        return $birthdayarray;
    }

    public function getCardDetails($id) {
        $currentYear = date('Y');
        $nextyear = date('Y', strtotime('+1 year'));
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $dbObj->where('YEAR(date_from) =', $currentYear);
        $dbObj->or_where('YEAR(date_to) >', $nextyear);
        $term = $dbObj->get("session_term_setting")->result_array();
        $dateArray = array(
            "startdate" => "",
            "end" => ""
        );
        for ($i = 0; $i < count($term); $i++) {
            $endsession = array();
            if ($term[$i]['item'] == 'TERM1') {
                $endsession['startdate'] = $term[$i]['date_from'];
            } else {
                $endsession['end'] = $term[$i]['date_to'];
            }
            $dateArray = array_merge($dateArray, $endsession);
        }
        $startsession = $dateArray['startdate'];
        $end = $dateArray['end'];
        $cardArray = array('BLUE', 'YELLOW', 'PINK', 'RED');
        $cardDetails = array();
        for ($k = 0; $k < count($cardArray); $k++) {
            $cardtype = $cardArray[$k];
            $query = "SELECT a.`id`,a.`card_type`,a.`adm_no`,a.`remarks`,a.`card_issue_date`,b.`firstname`,b.`lastname` FROM `cards_details` as a,`biodata` as b WHERE a.`card_type` = '$cardtype' AND a.`entry_by` = '$id' AND b.`adm_no` = a.`adm_no` ORDER BY a.`timestamp`";
            //$query = "SELECT a.`id`,a.`card_type`,a.`adm_no`,a.`remarks`,a.`card_issue_date`,b.`firstname`,b.`lastname` FROM `cards_details` as a,`biodata` as b WHERE a.`card_type` = '$cardtype' AND a.`entry_by` = '$id' AND b.`adm_no` = a.`adm_no` AND DATE(a.`timestamp`) BETWEEN '$startsession' AND '$end' ORDER BY a.`timestamp`";         
            $card[$cardtype] = $dbObj->query($query)->result_array();
            $cardDetails = array_merge($cardDetails, $card);
        }
        return $cardDetails;
    }

    public function getTodaysClass($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.subject_id,a.section_id');
        $dbObj->from('subject_staff_relation as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.staff_id', $id);
        $dbObj->where('b.status', 1);
        $staff_subject = $dbObj->get()->result_array();
        $subject = array();
        for ($i = 0; $i < count($staff_subject); $i++) {
            $section_id = $staff_subject[$i]['section_id'];
            $subject_id = $staff_subject[$i]['subject_id'];
            $sectionname = $this->getSectionClassList($section_id);
            $subjectname = $this->getSubjectList($subject_id);
            if (count($subjectname)) {
                $sectionname[0]['sbject'] = $subjectname[0]['subject_name'];
            } else {
                $sectionname[0]['sbject'] = '';
            }
            $totalstudent = $this->getSudentSubjectList($subject_id);
            if (count($totalstudent)) {
                $sectionname[0]['totalstudent'] = $totalstudent['totalstudent'];
                $sectionname[0]['presentstudent'] = $totalstudent['presentstudent'];
            } else {
                $sectionname[0]['totalstudent'] = '';
                $sectionname[0]['presentstudent'] = '';
            }
            $subject = array_merge($subject, $sectionname);
        }
        return $subject;
    }

    public function getNoticeList($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('notice_id');
        $dbObj->order_by('timestamp', 'DESC');
        $dbObj->where(array('notice_to_id' => $id, 'notice_type !=' => 'STUDENT', 'notice_type !=' => 'ALLSTUDENT'));
        $notice_id = $dbObj->get('notice_relation')->result_array();
        $noticeDetails = array();
        for ($i = 0; $i < count($notice_id); $i++) {
            $notice = $this->getNoticeDetails($notice_id[$i]['notice_id']);

            if (!empty($notice)) {
                $noticeDetails = array_merge($noticeDetails, $notice);
            }
        }
        return $noticeDetails;
    }

    public function getEventList($id) {

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $sessionTerm = $this->coreObj->GetSchoolTermDetails();
        $dbObj->select('id,name');
        $event = $dbObj->get_where('event_details', array('incharge_staff_id' => $id, 'event_end_date >=' => date('Y-m-d')))->result_array();
        $EventDetails = array();
        for ($i = 0; $i < count($event); $i++) {
            $team = $this->getEventTeamDetails($event[$i]['id']);
            $team[0]['name'] = $event[$i]['name'];
            $EventDetails = array_merge($EventDetails, $team);
            $EventDetails[$i]['id'] = $event[$i]['id'];
        }
        return $EventDetails;
    }

    public function getSubjectList($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('subject_name');
        return $dbObj->get_where("subject_list", array('id' => $id))->result_array();
    }

    public function getSudentSubjectList($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->distinct();
        $dbObj->select('a.adm_no');
        $dbObj->from('student_subject_relation as a');
        $dbObj->join('biodata as b', 'a.adm_no=b.adm_no');
        $dbObj->join('section_list as c', 'c.id=b.section_id');
        $dbObj->where(array('a.subject_id' => $id, 'c.status >' => 0, 'b.section_id !=' => -1));
        $student_adm = $dbObj->get()->result_array();
        $student = 0;
        for ($k = 0; $k < count($student_adm); $k++) {
            $adm_no = $student_adm[$k]['adm_no'];
            if ($this->getSudentSubjectAttendance($adm_no)) {
                $student++;
            }
        }
        return array('totalstudent' => count($student_adm), 'presentstudent' => $student);
    }

    public function getSudentSubjectAttendance($id) {
        $currentdate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('att_status');
        $sttResult = $dbObj->get_where("attendance_detail", array('adm_no' => $id, "att_status" => 'PRESENT', "attendance_date" => $currentdate))->row_array();

        if (!empty($sttResult)) {
            if ($sttResult['att_status'] == 'PRESENT') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getSectionClassList($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('standard,section');
        return $dbObj->get_where("section_list", array('id' => $id, 'status' => 1))->result_array();
    }

    public function getNoticeDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('title,notice_content,timestamp,entry_by');
        $dbObj->order_by('timestamp', 'DESC');
        $noticetitle = $dbObj->get_where("notice_details", array('id' => $id))->result_array();
        $noticeArray = array();
        for ($i = 0; $i < count($noticetitle); $i++) {
            $dataarray = array();
            $entry = $noticetitle[$i]['entry_by'];
            $issued = $this->getNoticeIssuedDetails($entry);
            $dataarray = $issued;
            $dataarray[0]['title'] = $noticetitle[$i]['title'];
            $dataarray[0]['notice_content'] = $noticetitle[$i]['notice_content'];
            $dataarray[0]['timestamp'] = ChangeMydateFormat($noticetitle[$i]['timestamp']);
            $noticeArray = array_merge($noticeArray, $dataarray);
        }
        return $noticeArray;
    }

    public function getNoticeIssuedDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('staff_fname,staff_lname,profile_pic_path');
        return $dbObj->get_where("staff_details", array('id' => $id))->result_array();
    }

    public function getEventTeamDetails($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('COUNT(`id`) as totalteam');
        return $dbObj->get_where("event_team_detail", array('event_id' => $id))->result_array();
    }

    public function issuecardDetails() {
        $issudate = date('Y-m-d');
        $json = json_decode($this->input->post('data'), TRUE);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data_insert = array(
            'adm_no' => $json['adm_no'],
            'remarks' => $json['todoname'],
            'card_issue_date' => $issudate,
            'card_type' => strtoupper($json['card_type']),
            'entry_by' => $this->session->userdata('staff_id'),
            'deo_entry_by' => $this->session->userdata('deo_staff_id')
        );
        $dbObj->insert('cards_details', $data_insert);
        return TRUE;
    }

    public function savetododata($tododata) {
        $data = array(
            'staff_id' => $tododata['staffid'],
            'task_name' => trim($tododata['todoname']),
            'status' => 'PENDING',
            'entry_by' => $this->session->userdata('staff_id'),
            'deo_entry_by' => $this->session->userdata('deo_staff_id')
        );

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $savedata = $dbObj->insert('staff_todo_list', $data);

        if ($dbObj->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCards() {
        $delete_id = $this->input->post('data');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('cards_details', array('id' => $delete_id));
        return TRUE;
    }

    public function deletetododata() {
        $deleted_id = $this->input->post('data');
        //print_r($deleted_id); exit;
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('staff_todo_list', array('id' => $deleted_id));
        return TRUE;
    }

    public function GetSearchStudent($name) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no,firstname,lastname');
        $dbObj->like('firstname',$name);
        $result = $dbObj->get('biodata')->result_array();
        return $result;
    }

    public function GetHomeworkdetail($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,title,type,submission_last_date,subject_id,section_id');
        $homeWorkData = $dbObj->get_where('homework_master_list', array('entry_by' => $staff_id))->result_array();

        if (!empty($homeWorkData)) {
            for ($i = 0; $i < count($homeWorkData); $i++) {
                $subject_deatil = $this->GetSubjectName($homeWorkData[$i]['subject_id'], $dbObj);
                $className = $this->GetClassName($homeWorkData[$i]['section_id'], $dbObj);
                $homeWorkData[$i]['submission_last_date'] = ChangeMydateFormat($homeWorkData[$i]['submission_last_date']);
                $homeWorkData[$i]['subject_name'] = $subject_deatil['subject_name'];
                $homeWorkData[$i]['class'] = $className['standard'] . $className['section'];
            }
//            print_r($homeWorkData);exit;
            return $homeWorkData;
        }
        return -1;
    }

    public function GetSubjectName($subjectId, $dbObj) {
        $dbObj->select('subject_name');
        $subjectName = $dbObj->get_where('subject_list', array('id' => $subjectId))->row_array();
        if (!empty($subjectName)) {
            return $subjectName;
        } else {
            return -1;
        }
    }

    public function GetClassName($sectionId, $dbObj) {
        $dbObj->select('standard,section');
        $sectionDetail = $dbObj->get_where('section_list', array('id' => $sectionId))->row_array();
        if (!empty($sectionDetail)) {
            return $sectionDetail;
        } else {
            return -1;
        }
    }

    public function UpadteProfilePic($profile_pic) {
        $data = array('profile_pic_path' => $profile_pic, "profile_pic_path_thumbnail" => $profile_pic);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $this->session->userdata('staff_id'));
        $dbObj->update('staff_details', $data);
        $row = $dbObj->affected_rows();
        if ($row > 0) {
            return $row;
        }
    }

    public function getTodoList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $date = date('Y-m-d', strtotime("-5 days"));
        $dbObj->select('id,task_name,status');
        $dbObj->order_by('status', 'desc');
        $alltodoList = $dbObj->get_where('staff_todo_list', array('DATE(`timestamp`) >' => $date, 'entry_by' => $this->session->userdata('staff_id')))->result_array();
        foreach ($alltodoList as $key => $value) {
            if ($value['status'] == 'COMPLETED') {
                $alltodoList[$key]['todo_class'] = "background:#4caf50";
            } else {
                $alltodoList[$key]['todo_class'] = "background:#FF5833";
            }
        }
        return $alltodoList;
    }

    public function viewTodoList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,task_name,status');
        $viewtodoList = $dbObj->get_where('staff_todo_list', array('entry_by' => $this->session->userdata('staff_id')))->result_array();
        return $viewtodoList;
    }

    public function todocomplete() {
        $check_id = $this->input->post('data');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $check_id);
        $dbObj->update('staff_todo_list', array('status' => "COMPLETED", 'entry_by' => $this->session->userdata('staff_id')));
        return TRUE;
    }

    //******************************Staff Attendance Admin*********************************************

    public function CheckHoliday($date) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('is_holiday');
        $dbObj->from('session_days');
        $dbObj->where('date', $date);
        $arrHoliday = $dbObj->get()->result_array();
        if ($arrHoliday[0]['is_holiday'] == 'Yes') {
            return true;
        } else {
            return false;
        }
    }

    public function GetStaffAttendence($staff_desig, $result, $date) {
        if ($staff_desig == 'ADMIN') {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $myFinalDetail = array();
            $resultHoliday = $this->CheckHoliday($date);
            if ($resultHoliday == true) {
                return 'HOLIDAY';
            } else {
                $dbObj->select('status');
                $status = $dbObj->get_where('staff_attendance_detail', array('att_date' => $date))->row_array();
                if (empty($status)) {
                    $status['status'] = 'Unmarked';
                }
                foreach ($result as $value) {
                    $myTempResult = $dbObj->get_where('staff_attendance', array("staff_id" => $value['id'], "date" => $date))->row_array();
                    if (isset($myTempResult['staff_id'])) {
                        $myFinalDetail[] = array("staff_id" => $value['id'], "name" => $value['staff_fname'] . ' ' . $value['staff_lname'], "att_status" => strtoupper($myTempResult['status']), "reason" => $myTempResult['reason']);
                    } else {
                        $myFinalDetail[] = array("staff_id" => $value['id'], "name" => $value['staff_fname'] . ' ' . $value['staff_lname'], "att_status" => "PRESENT", "reason" => "");
                    }
                }
                $merge = array('staff_list' => $myFinalDetail, 'status' => $status);
                return $merge;
            }
        } else {
            return 'NOTADMIN';
        }
    }

    public function MarkAllAttendenceDetail($myArr, $date) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data_all = array();
        $data_status = array('att_date' => $date, 'status' => 'Marked', 'entry_by' => $this->session->userdata('staff_id'));

        if ($this->session->userdata('staff_desig') == 'ADMIN') {
            $dbObj->delete('staff_attendance', array('date' => $date, 'status' => 'ABSENT'));
            $dbObj->select('*');
            $result = $dbObj->get_where('staff_attendance_detail', array('att_date' => $date))->row_array();
            if (empty($result)) {
                $dbObj->insert('staff_attendance_detail', $data_status);
                if ($dbObj->affected_rows() == 0) {
                    return - 1;
                } else {
                    return $dbObj->insert_id();
                }
            }
        } else {
            return false;
        }
    }

    public function MarkStaffAtt($data_staff, $date) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($this->session->userdata('staff_desig') == 'ADMIN') {
            $status_update = $this->MarkTodyStatus($dbObj, $date);
            if ($data_staff['status'] == 'ABSENT') {
                $data_staff_det = array('staff_id' => $data_staff['staff_id'], 'date' => $date, 'status' => $data_staff['status'], 'reason' => $data_staff['reason'], 'deo_entry_by' => $this->session->userdata('deo_staff_id'), 'entry_by' => $this->session->userdata('staff_id'));
                $dbObj->delete('staff_attendance', array('date' => $date, 'status' => 'ABSENT', 'staff_id' => $data_staff['staff_id']));
                $dbObj->insert('staff_attendance', $data_staff_det);
                if ($dbObj->affected_rows() == 0) {
                    return false;
                } else {
                    return $dbObj->insert_id();
                }
            } else {
                $dbObj->delete('staff_attendance', array('date' => $date, 'staff_id' => $data_staff['staff_id']));
                return true;
            }
        } else {
            return false;
        }
    }

    public function MarkTodyStatus($dbObj, $date) {
        $data = array('att_date' => $date, 'status' => 'Marked', 'entry_by' => $this->session->userdata('staff_id'));
        $dbObj->select('*');
        $result = $dbObj->get_where('staff_attendance_detail', array('att_date' => $date))->row_array();
        if (!empty($result)) {
            return false;
        } else {
            $dbObj->insert('staff_attendance_detail', $data);
            if ($dbObj->affected_rows() == 0) {
                return - 1;
            } else {
                return $dbObj->insert_id();
            }
        }
    }

}
