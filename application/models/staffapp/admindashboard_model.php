<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class admindashboard_model extends CI_Model {

    public function GetCardCount($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $totcardCount = array();
        $currdate = date('Y-m-d');
        $term = array('TERM1', 'TERM2');
        $dbObj->select('date_from,date_to,item');
        $dbObj->where_in('item', $term);
        $term_dates = $dbObj->get("session_term_setting")->result_array();
        $dbObj->select('upper(card_type) as card_name,count(card_type) as issue_total');
        $dbObj->group_by('card_type');
        $totcardCount = $dbObj->get_where('cards_details', array('approved_status' => 'YES'))->result_array();

        foreach ($totcardCount as $key => $value) {
            if ($value['card_name'] == '' || $value['card_name'] == null) {
                unset($totcardCount[$key]);
            }
        }
       for ($i = 1; $i <= count($totcardCount); $i++) {
            $dbObj->select('count(card_type) as card_count');
            $dbObj->group_by('card_type');
            $todaycards = $dbObj->get_where('cards_details', array('card_issue_date' => $currdate, 'card_type' => $totcardCount[$i]['card_name']))->row_array();
            if (!empty($todaycards)) {
                $totcardCount[$i]['issue_today'] = $todaycards['card_count'];
            } else {
                $totcardCount[$i]['issue_today'] = 0;
            }
        }
        $cardCount = array_values($totcardCount);
        return $cardCount;
    }

    public function UpComingHoliday($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("holiday_reason,timestamp,DATE_FORMAT(date,'%D %M, %Y') as date,DATE_FORMAT(date,'%W') as weekday,", FALSE);
        $dbObj->from('session_holiday_details');
        $dbObj->where('date > now()');
        $dbObj->order_by('YEAR(`date`)');
        $dbObj->order_by('MONTH(`date`)');
        $dbObj->order_by('DAY(`date`)');
        $holidayDeatils = $dbObj->get()->result_array();
        $arrFinalHoliday = array();
        $i = 0;
        foreach ($holidayDeatils as $val) {
            $arrHoliday = array("resn" => $val['date'] . '(' . $val['holiday_reason'] . ')');
            $arrFinalHoliday[$i] = $arrHoliday;
            $i++;
        }
        if (!empty($arrFinalHoliday)) {
            return $arrFinalHoliday;
        } else {
            return array();
        }
    }

    public function getBirthday($dataObj) {
        $todaydate = date('Y-m-d');
        $nexttendate = date('Y-m-d', strtotime('+10 day', strtotime($todaydate)));
        $nextday = date("d-m", strtotime('+1 day', strtotime($todaydate)));
        $currentday = date("d-m", strtotime($todaydate));
        $birthdayarray = array();
        while ($todaydate < $nexttendate) {
            $month = date("m", strtotime($todaydate));
            $day = date("d", strtotime($todaydate));
            $dbObj = $this->load->database($dataObj['database'], TRUE);
            $studenttemarray = array();
            $stafftemarray = array();
            $dbObj->select('adm_no,firstname,lastname,dob_date,profile_pic_path');
            $dbObj->where('MONTH(dob_date)', $month);
            $dbObj->where('DAY(dob_date)', $day);
            $dbObj->where('section_id >', 0);
            $dbObj->limit(10);
            $studentbirthdayarray = $dbObj->get('biodata')->row_array();
            if (!empty($studentbirthdayarray)) {
                $month_day = date("d-m", strtotime($studentbirthdayarray['dob_date']));
                if ($currentday == $month_day) {
                    $studentbirthdayarray['day'] = 'Today';
                } elseif ($nextday == $month_day) {
                    $studentbirthdayarray['day'] = 'Tommorrow';
                } else {
                    $studentbirthdayarray['day'] = $month_day . '-' . date('Y');
                }
                $studentbirthdayarray['type'] = 'STUDENT';
                $studenttemarray = array_merge($studenttemarray, $studentbirthdayarray);
            }
            $dbObj->select('id,staff_fname as firstname,staff_lname as lastname,dob_date,profile_pic_path');
            $dbObj->where('MONTH(dob_date)', $month);
            $dbObj->where('DAY(dob_date)', $day);
            $dbObj->limit(10);
            $staffbirthdayarray = $dbObj->get('staff_details')->row_array();
            if (!empty($staffbirthdayarray)) {
                $month_day = date("d-m", strtotime($staffbirthdayarray['dob_date']));
                if ($currentday == $month_day) {
                    $staffbirthdayarray['day'] = 'Today';
                } elseif ($nextday == $month_day) {
                    $staffbirthdayarray['day'] = 'Tommorrow';
                } else {
                    $staffbirthdayarray['day'] = $month_day . '-' . date('Y');
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

    public function getBirthdayJson($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $birthdata = array();
        $birthdayData = array();
        $birthdata = $this->getBirthday($dataObj);
        for ($i = 0; $i < count($birthdata); $i++) {
            if ($birthdata[$i]['type'] == "STAFF") {
                $staffnamepic = $this->coreObj->GetStaffName($birthdata[$i]['id'], $dbObj);
                $staff_det = $this->coreObj->GetImportentDetails($birthdata[$i]['id'], $dataObj['database']);
                $birthdayData[] = array('name' => $staffnamepic['staff_name'] . '(' . $birthdata[$i]['type'] . ')', 'date' => date("jS M  ", strtotime($birthdata[$i]['dob_date'])), 'class' => $staff_det['class'] . $staff_det['section']);
            } else {
                $studentnamepic = $this->coreObj->GetStudentDetail($birthdata[$i]['adm_no'], $dbObj);
                $stu_class = $this->GetStudentclass($birthdata[$i]['adm_no'], $dbObj);
                $birthdayData[] = array('name' => $studentnamepic['student_name'] . '(' . $birthdata[$i]['type'] . ')', 'date' => date("jS M  ", strtotime($birthdata[$i]['dob_date'])), 'class' => $stu_class);
            }
        }
        return $birthdayData;
    }

    public function GetStudentclass($adm_no, $dbObj) {
        $dbObj->select('a.firstname,a.lastname,b.standard as standard,b.section as section');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $result = $dbObj->get()->row_array();
        if (!empty($result)) {
            $result_det = $result['standard'] . " " . $result['section'];
            return $result_det;
        }
    }

    public function GetExamDatesheet($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $examdatesheet = array();
        $examdatesheet_Data = array();
        $dbObj->select('id,exam_name,standard,section_type');
        $dbObj->limit(10);
        $examdatesheet = $dbObj->get('exam_datesheet_details')->result_array();
        if (!empty($examdatesheet)) {
            for ($i = 0; $i < count($examdatesheet); $i++) {
                if ($examdatesheet[$i]['section_type'] != 'ALL') {
                    $temSectionArr = array();
                    $dbObj->select('a.section,a.standard');
                    $dbObj->from('section_list as a');
                    $dbObj->join('exam_datesheet_section_relation as b', 'a.id=b.section_id');
                    $dbObj->where('exam_id', $examdatesheet[$i]['id']);
                    $sectionName = $dbObj->get()->result_array();
                    if (!empty($sectionName)) {
                        foreach ($sectionName as $row) {
                            $temSectionArr[] = $row['standard'] . '' . $row['section'];
                        }
                        $concateSectionName = implode(',', $temSectionArr);
                        $examdatesheet_Data[] = array('dtesht' => "(" . $concateSectionName . ") " . $examdatesheet[$i]['exam_name']);
                    }
                } else {
                    $examdatesheet_Data[] = array('dtesht' => "(" . $examdatesheet[$i]['standard'] . ") " . $examdatesheet[$i]['exam_name']);
                }
            }
            return $examdatesheet_Data;
        } else {
            return -1;
        }
    }

    public function GetEvent($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $monday = date('Y-m-d', strtotime('monday this week'));
        $sunday = date('Y-m-d',strtotime('+6 day', strtotime($monday)));
        $curr_date = date('Y-m-d');
        $month_str = date('Y-m-d', strtotime('first day of this month'));
        $month_end = date('Y-m-d', strtotime('last day of this month'));
        $dbObj->select('count(id) as todayevnt');
        $dbObj->where('on_date',$curr_date);
        $event_today = $dbObj->get('event_details')->row_array();
        $dbObj->select('count(id) as mnthevnt');
        $event_mnth = $dbObj->get_where('event_details', array('on_date <=' => $month_end, 'on_date >=' => $month_str))->row_array();
        $dbObj->select('count(id) as weekevnt');
        $event_week = $dbObj->get_where('event_details', array('on_date <=' => $sunday, 'on_date >=' => $monday))->row_array();
        $eventlist = array('day' => $event_today['todayevnt'] . " events today", 'week' => $event_week['weekevnt'] . " events in this week", 'month' => $event_mnth['mnthevnt'] . ' events in this month');
        return $eventlist;
    }

    public function getNoticeList($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $curr_date = date('Y-m-d');
        $dbObj->select('count(id) as tot_notice');
        $tot_notice = $dbObj->get('notice_details')->row_array();
        $dbObj->select('count(id) as today_notice');
        $dbObj->where("DATE_FORMAT(timestamp,'%Y-%m-%d')", $curr_date);
        $today_notice = $dbObj->get('notice_details')->row_array();
        $final_arr = array('ttl_issued' => "Total issued:" . $tot_notice['tot_notice'], 'today' => 'Today ' . $today_notice['today_notice'] . ' issued');
        return $final_arr;
    }

    public function getLibData($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $curr_date = date('Y-m-d');
        $dbObj->select_sum('quantity', 'quantity');
        $tot_books = $dbObj->get('lms_book_quantity_detail')->row_array();
        $dbObj->select('count(id) as tot_issued');
        $tot_issued = $dbObj->get('lms_book_issue_detail')->row_array();
        $dbObj->select('count(id) as today_issued');
        $dbObj->where('issue_date', $curr_date);
        $dbObj->where('status', 'ISSUED');
        $today_issued = $dbObj->get('lms_book_issue_detail')->row_array();
        $dbObj->select('count(id) as today_return');
        $dbObj->where('issue_date', $curr_date);
        $dbObj->where('status', 'RETURN');
        $today_returnd = $dbObj->get('lms_book_issue_detail')->row_array();
        $final_arr = array('ttl_issue' => 'Total issued:' . $tot_issued['tot_issued'] . '/' . $tot_books['quantity'], 'today' => 'Today:' . $today_issued['today_issued'] . ' Issued |' . $today_returnd['today_return'] . ' return');
        return $final_arr;
    }

    public function getLateData($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $curr_date = date('Y-m-d');
        $dbObj->select('count(id) as count');
        $stu_late = $dbObj->get_where('late_coming_details', array('coming_date' => $curr_date))->row_array();
        $staff_late = 23;
        $total = $stu_late['count'] + $staff_late;
        $final_arr = array('total' => $total . ' people are late', 'staff' => 'staff:' . $staff_late, 'student' => 'student:' . $stu_late['count']);
        return $final_arr;
    }

//    public function getAttData($dataObj) {
//        $dbObj = $this->load->database($dataObj['database'], TRUE);
//        $curr_date = date('Y-m-d');
//        $dbObj->select('count(id) as present');
//        $dbObj->distinct('adm_no');
//        $stu_present = $dbObj->get_where('attendance_detail', array('attendance_date' => $curr_date, 'att_status' => 'PRESENT'))->row_array();
//        $dbObj->select('count(id) as late');
//        $dbObj->distinct('adm_no');
//        $stu_late = $dbObj->get_where('attendance_detail', array('attendance_date' => $curr_date, 'att_status' => 'ABSENT'))->row_array();
//        $total = $stu_present['present'] + $stu_late['late'];
//        $final_arr_staff = array('total' => 'Total:21', 'present' => '17 Staff are prsent', 'absent' => '4 Staff are absent');
//        $final_arr_stu = array('total' => 'Total:' . $total, 'present' => $stu_present['present'] . ' Students are prsent', 'absent' => $stu_late['late'] . ' students are absent');
//        $final_arr = array('staff' => $final_arr_staff, 'stud' => $final_arr_stu);
//        return $final_arr;
//    }

    public function getAttData($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $curr_date = date('Y-m-d');
        $dbObj->select('count(id) as present');
        $dbObj->distinct('adm_no');
        $stu_present = $dbObj->get_where('attendance_detail', array('attendance_date' => $curr_date, 'att_status' => 'PRESENT'))->row_array();
        $dbObj->select('count(id) as late');
        $dbObj->distinct('adm_no');
        $stu_late = $dbObj->get_where('attendance_detail', array('attendance_date' => $curr_date, 'att_status' => 'ABSENT'))->row_array();
        $total = $stu_present['present'] + $stu_late['late'];
        $totalStaff = $this->GetAllStaff($dataObj);
        $getAbsentStaff = $this->getStaffAttDetail($dataObj);
        if ($getAbsentStaff == 'Today Attendance not taken') {
            $totalPresntStaff = 'Today Attendance not taken';
            $getAbsentStaff = 'Today Attendance not taken';
        } else {
            $totalPresntStaff = (count($totalStaff) - count($getAbsentStaff)) . ' Staffs are present';
            $getAbsentStaff = count($getAbsentStaff) . ' Staffs are absent';
        }
        $final_arr_staff = array('total' => 'Total Staff:' . count($totalStaff) . ' Staffs', 'present' => $totalPresntStaff, 'absent' => $getAbsentStaff);
        $final_arr_stu = array('total' => 'Total Student:' . $total, 'present' => $stu_present['present'] . ' Students are present', 'absent' => $stu_late['late'] . ' students are absent');
        $final_arr = array('staff' => $final_arr_staff, 'stud' => $final_arr_stu);
        return $final_arr;
    }

    public function getLogin($dataObj, $school_code) {
        $curr_date = date('Y-m-d');
        $staffCount = $this->GetStaffCount($school_code, $curr_date);
        $stuCount = $this->GetStudCount($school_code, $curr_date);
        $result_staff = $this->GetAllStaff($dataObj);
        foreach ($result_staff as $value) {
            if ($staffCount['staff_count'] != 0) {
                $name = $value['staff_fname'] . ' ' . $value['staff_lname'];
                $arrCountLoginStaff[] = $this->CountLoginStaff($value['id'], $name);
            } else {
                $arrCountLoginStaff = 0;
            }
        }
        for ($i = 0; $i < count($stuCount); $i++) {
            if (!empty($stuCount)) {
                $stu_name_class = $this->GetStudentName($stuCount[$i]['adm_no'], $dataObj);
                $arrCountLoginStu[] = $this->CountLoginStu($stuCount[$i]['id'], $stu_name_class);
            } else {
                $arrCountLoginStu = 0;
            }
        }
        $final_arr = array('stud' => count($stuCount) . ' Students logged in', 'staff' => $staffCount['staff_count'] . ' Staff logged in');
        if (!empty($stuCount)) {
            $max_value_Stu = max($arrCountLoginStu);
            $final_arr['max_stu'] = $max_value_Stu['stud_name'] . $max_value_Stu['stud_count'];
        } else {
            $final_arr['max_stu'] = "0 Students logged in";
        }
        if ($staffCount['staff_count'] != 0) {
            $max_value_staff = max($arrCountLoginStaff);
            $final_arr['max_staff'] = $max_value_staff['staff_name'] . $max_value_staff['staff_count'];
        } else {
            $final_arr['max_staff'] = "0 Staff logged in";
        }
         return $final_arr;
    }

    public function GetStaffCount($school_code, $curr_date) {
        $this->db->select('count(a.id) as staff_count');
        $this->db->from('system_users as a');
        $this->db->join('user_login_logs as b', 'a.id=b.user_id');
        $this->db->where('a.member_type', 'STAFF');
        $this->db->where('a.school_code', $school_code);
        $this->db->where("DATE_FORMAT(b.timestamp,'%Y-%m-%d')", $curr_date);
        return $this->db->get()->row_array();
    }

    public function GetStudCount($school_code, $curr_date) {
        $this->db->select('a.id,c.adm_no');
        $this->db->from('system_users as a');
        $this->db->join('user_login_logs as b', 'a.id=b.user_id');
        $this->db->join('user_std_relation as c', 'a.id=c.user_id');
        $this->db->where('a.member_type', 'PARENT');
        $this->db->where('a.school_code', $school_code);
        $this->db->group_by('c.user_id');
        $this->db->where("DATE_FORMAT(b.timestamp,'%Y-%m-%d')", $curr_date);
        return $this->db->get()->result_array();
    }

    public function GetAllStaff($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('id,staff_fname,staff_lname,profile_pic_path,profile_pic_path_thumbnail,mobile_no_for_sms');
        return $dbObj->get_where('staff_details', array('status' => 'ACTIVE'))->result_array();
    }

    public function getStaffAttDetail($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $curr_date = date('Y-m-d');
        $dbObj->select('id,att_date');
        $getAttMarkStatus = $dbObj->get_where('staff_attendance_detail', array('att_date' => $curr_date, 'status' => 'Marked'))->row_array();
        if (empty($getAttMarkStatus)) {
            $notmarked = 'Today Attendance not taken';
            return $notmarked;
        } else {
            $dbObj->select('staff_id,reason');
            $getAbsentStaff = $dbObj->get_where('staff_attendance', array('date' => $getAttMarkStatus['att_date'], 'status' => 'ABSENT'))->result_array();
            return $getAbsentStaff;
        }
    }

    public function GetStudentName($adm_no, $dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('a.firstname,a.lastname,b.standard,b.section');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $studata = $dbObj->get()->row_array();
        if (!empty($studata)) {
            return $studata['firstname'] . ' ' . $studata['lastname'] . '-' . $studata['standard'] . $studata['section'];
        } else {
            return $studata;
        }
    }

    public function CountLoginStaff($user_id, $staff_name, $pic = NULL) {
        $curr_date = date('Y-m-d');
        $this->db->select('count(id) as staff_count');
        $count = $this->db->get_where('user_login_logs', array('user_id' => $user_id, "DATE_FORMAT(timestamp,'%Y-%m-%d')" => $curr_date))->row_array();
        $count['staff_count'] = "(" . $count['staff_count'] . " times)";
        $count['staff_name'] = $staff_name;
        $count['staff_pic'] = $pic;
        return $count;
    }

    public function CountLoginStu($user_id, $stu_name_class, $stu_pic = NULL) {
        $curr_date = date('Y-m-d');
        $this->db->select('count(id) as stud_count');
        $count = $this->db->get_where('user_login_logs', array('user_id' => $user_id, "DATE_FORMAT(timestamp,'%Y-%m-%d')" => $curr_date))->row_array();
        $count['stud_count'] = "(" . $count['stud_count'] . " times)";
        $count['stud_name'] = $stu_name_class;
        $count['std_pic'] = $stu_pic;
        return $count;
    }

    public function getRecntlyLogin($dataObj, $school_code) {
        $arrCountLoginStu = array();
        $arrCountLoginStaff = array();
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $curr_date = date('Y-m-d');
        $staffCount = $this->GetrcntlyStaffCount($school_code, $curr_date, $dbObj);
        $stuCount = $this->GetrcntlyStudCount($school_code, $curr_date, $dbObj);
        foreach ($staffCount as $value) {
            if (!empty($value)) {
                $arrCountLoginStaff[] = $this->CountLoginStaff($value['id'], $value['name'], $value['pic']);
            } else {
                $arrCountLoginStaff = 0;
            }
        }
        for ($i = 0; $i < count($stuCount); $i++) {
            if (!empty($stuCount)) {
                $arrCountLoginStu[] = $this->CountLoginStu($stuCount[$i]['id'], $stuCount[$i]['name'], $stuCount[$i]['pic']);
            } else {
                $arrCountLoginStu = 0;
            }
        }
       $final_arr = array('student' => $arrCountLoginStu, 'staff' => $arrCountLoginStaff);
        return $final_arr;
    }

    public function GetrcntlyStaffCount($school_code, $curr_date, $dbObj) {
        $this->db->select('a.id,a.staff_id');
        $this->db->group_by('a.id');
        $this->db->from('system_users as a');
        $this->db->join('user_login_logs as b', 'a.id=b.user_id');
        $this->db->limit(10);
        $this->db->order_by('b.timestamp', 'desc');
        $this->db->where('a.member_type', 'STAFF');
        $this->db->where('a.school_code', $school_code);
        $this->db->where("DATE_FORMAT(b.timestamp,'%Y-%m-%d')", $curr_date);
        $staff_id = $this->db->get()->result_array();
        if (!empty($staff_id)) {
            $this->load->model('staffapp/staffapp_core', 'coreObj');
            for ($i = 0; $i < count($staff_id); $i++) {
                $staff_name = $this->coreObj->GetStaffName($staff_id[$i]['staff_id'], $dbObj);
                $final_arr[] = array('id' => $staff_id[$i]['id'], 'name' => $staff_name['staff_name'], 'pic' => $staff_name['staff_pic']);
            }
            return $final_arr;
        } else {
            return $staff_id;
        }
    }

    public function GetrcntlyStudCount($school_code, $curr_date, $dbObj) {
        $final_arr = array();
        $this->db->select('a.id,c.adm_no');
        $this->db->group_by('c.adm_no');
        $this->db->from('system_users as a');
        $this->db->join('user_login_logs as b', 'a.id=b.user_id');
        $this->db->join('user_std_relation as c', 'a.id=c.user_id');
        $this->db->limit(10);
        $this->db->order_by('b.timestamp', 'desc');
        $this->db->where('a.member_type', 'PARENT');
        $this->db->where('a.school_code', $school_code);
        $this->db->where("DATE_FORMAT(b.timestamp,'%Y-%m-%d')", $curr_date);
        $adm_no = $this->db->get()->result_array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        for ($i = 0; $i < count($adm_no); $i++) {
            $stu_name = $this->coreObj->GetStudentDetail($adm_no[$i]['adm_no'], $dbObj);
            $final_arr[] = array('id' => $adm_no[$i]['id'], 'name' => $stu_name['student_name'] . ' (' . $stu_name['class'] . ')', 'pic' => $stu_name['student_pic']);
        }
        return $final_arr;
    }

    public function getFeesData($dataObj) {
        $final_arr = array('submtd' => '54 Students submitted (45/650)', 'non_subt' => 'Collection today:20,000 (26 students)', 'last_date' => 'Collection this month: 4,35,600 (635 students)');
        return $final_arr;
    }

    public function getWeeklyLogin($dataObj, $school_code) {
        $current_date = date('Y-m-d');
        $next_date = date('Y-m-d', strtotime(" -5 days"));
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('date as log_date');
        $date = $dbObj->get_where('session_days', array('date <=' => $current_date, 'date >=' => $next_date))->result_array();
        for ($i = 0; $i < count($date); $i++) {
            $date_r = date('d-M', strtotime($date[$i]['log_date']));
            $staff_count = $this->GetStaffCount($school_code, $date[$i]['log_date']);
            $stud_count = $this->GetStudCount($school_code, $date[$i]['log_date']);
            $final_arr[] = array('login_day' => $date_r, 'login_staff' => $staff_count['staff_count'], 'login_stud' => count($stud_count));
        }
        return $final_arr;
    }

    public function getWeeklyAttndnc($dataObj, $school_code) {
        $current_date = date('Y-m-d');
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('date as log_date');
        $dbObj->order_by('log_date', 'DESC');
        $dbObj->limit(6);
        $date = $dbObj->get_where('session_days', array('date <=' => $current_date, 'is_holiday' => 'No'))->result_array();
        $date = array_reverse($date);
        for ($i = 0; $i < count($date); $i++) {
            $date_r = date('d-M', strtotime($date[$i]['log_date']));
            $staff_count = $this->GetStaffAttCount($dbObj, $date[$i]['log_date']);
            $stud_count = $this->GetStudAttCount($dbObj, $date[$i]['log_date']);
            $final_arr[] = array('att_day' => $date_r, 'att_staff' => $staff_count, 'att_stud' => $stud_count);
        }

        return $final_arr;
    }

    public function GetStaffAttCount($dbObj, $date) {
        $dbObj->select('count(id) as staffabs_count');
        $count = $dbObj->get_where('staff_attendance', array('status' => 'ABSENT', 'date' => $date))->row_array();
        return $count['staffabs_count'];
    }

    public function GetStudAttCount($dbObj, $date) {
        $dbObj->select('count(id) as studabs_count');
        $count = $dbObj->get_where('attendance_detail', array('att_status' => 'ABSENT', 'attendance_date' => $date))->row_array();
        return $count['studabs_count'];
    }

}
