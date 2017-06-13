<?php

class appstaffdashboard_model extends CI_Model {

    public function AdminDashboardjson() {
        $cards = array("Yellow:50 Today:20", "Red:60 Today:15", "Blue:35 Today:29", "Pink:40 Today:33");
        $attendance = array("Present:42", "Absent:4", "Sections Attendance Not Taken:2");
        $login_detail = array("10 Dec 2015", "Staff:1", "Student:1");
        $holiday = array("25th Dec 2015(Christmas)", "1st Jan 2016(Happy New Year)", "26th Jan 2016(Happy Republic Day)");
        $birthday = array("10 Dec 2015", "1241.Richa Dhingra(Student)", "K.C Thomas(Staff)");
        $late_entry = array("10 Dec 2015", "1241.Richa Dhingra(8A)");
        $examdatesheet = array("Term 1 First Test(4B,4C)", "Class Test(7A)", "FA1(5)");
        $absent_staff = array("3 faculty absent(10 Dec 2015)");
        $absent_student = array("13310.Mayank Bhatia(10 Dec 2015)");
        $temparray = array("cards" => $cards, "attendance" => $attendance, "login_detail" => $login_detail, "holidays" => $holiday, "birthday" => $birthday, "late_entry" => $late_entry, "exam_datesheet" => $examdatesheet, "absent_staff" => $absent_staff, "absent_student" => $absent_student);
        return $temparray;
    }

    public function getBirthday($dataObj) {
        $todaydate = date('Y-m-d');
        $nexttendate = date('Y-m-d', strtotime('+45 day', strtotime($todaydate)));
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
                    $day_stu = date("l", strtotime($month_day . '-' . date('Y')));
                    $studentbirthdayarray['day'] = $month_day . '-' . date('Y') . '(' . $day_stu . ')';
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
                    $day = date("l", strtotime($month_day . '-' . date('Y')));
                    $staffbirthdayarray['day'] = $month_day . '-' . date('Y') . '(' . $day . ')';
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
                $birthdayData[] = array('btd_type' => $birthdata[$i]['type'], 'btd_date' => date("jS F Y ", strtotime($birthdata[$i]['dob_date'])), 'btd_name' => $staffnamepic['staff_name'], 'btd_staff_id' => $birthdata[$i]['id'], 'prof_pic' => $staffnamepic['staff_pic']);
            } else {
                $studentnamepic = $this->coreObj->GetStudentDetail($birthdata[$i]['adm_no'], $dbObj);
                $birthdayData[] = array('btd_type' => $birthdata[$i]['type'], 'btd_date' => date("jS F Y ", strtotime($birthdata[$i]['dob_date'])), 'btd_name' => $studentnamepic['student_name'], 'btd_staff_id' => $birthdata[$i]['adm_no'], 'prof_pic' => $studentnamepic['student_pic']);
            }
        }
        return $birthdayData;
    }

    public function getTodoList($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $alltodoList = array();
        $todoData = array();
        $dbObj->select('id,task_name');
        $dbObj->limit(10);
        $alltodoList = $dbObj->get_where('staff_todo_list', array('Status' => "PENDING"))->result_array();
        for ($i = 0; $i < count($alltodoList); $i++) {
            $todoData['todo_id'] = $alltodoList[$i]['id'];
            $todoData['todo'] = $alltodoList[$i]['task_name'];
        }
        return $alltodoList;
    }
    
    // ******** new deletetodolist ************
    public function deleteTodoList($postDataObj,$dataObj) {
      $dbObj = $this->load->database($dataObj['database'], TRUE);
      $dbObj->update('staff_todo_list',array('id'=>$postDataObj['id'] ,'Status'=>"COMPLETED"));
      
    }
// ******** END new deletetodolist ************
    public function GetHomeworkdetail($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $homeWorkData = array();
        $homework_Data = array();
        $dbObj->select('id,title,type,submission_last_date');
        $dbObj->limit(10);
        $homeWorkData = $dbObj->get_where('homework_master_list', array('entry_by' => $dataObj['id']))->result_array();
        if (!empty($homeWorkData)) {
            for ($i = 0; $i < count($homeWorkData); $i++) {
                $homework_Data[] = array('hw_id' => $homeWorkData[$i]['id'], 'hw_type' => $homeWorkData[$i]['type'], 'hw_title' => $homeWorkData[$i]['title'], 'hw_sub_date' => date("jS F,Y ", strtotime($homeWorkData[$i]['submission_last_date'])));
            }
            return $homework_Data;
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
                        $examdatesheet_Data[] = array('exmdts_id' => $examdatesheet[$i]['id'], 'exm_name' => $examdatesheet[$i]['exam_name'] . "(class " . $examdatesheet[$i]['standard'] . ")");
                    }
                } else {
                    $examdatesheet_Data[] = array('exmdts_id' => $examdatesheet[$i]['id'], 'exm_name' => $examdatesheet[$i]['exam_name'] . "(class " . $examdatesheet[$i]['standard'] . ")");
                }
            }
            return $examdatesheet_Data;
        } else {
            return -1;
        }
    }

        public function getNoticeList($dataObj) {
        $noticeDetails = array();
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('notice_id');
        $dbObj->where('notice_to_id', $dataObj['id']);
        $dbObj->where('notice_type', 'ALLSTAFF');
        $dbObj->order_by('timestamp', 'DESC');
        $dbObj->limit(10);
        $notice_id = $dbObj->get('notice_relation')->result_array();
        for ($i = 0; $i < count($notice_id); $i++) {
            $notice = $this->getNoticeDetails($notice_id[$i]['notice_id'], $dbObj);
            if (!empty($notice)) {
                $noticeDetails = array_merge($noticeDetails, $notice);
            }
        }
        
        return $noticeDetails;
    }

    public function getNoticeDetails($notice_id, $dbObj) {
        $noticetitle = array();
        $dbObj->select('notice_type,notice_content,timestamp,entry_by');
        $dbObj->order_by('timestamp', 'DESC');
        $noticetitledata = $dbObj->get_where("notice_details", array('id' => $notice_id))->row_array();
        if (!empty($noticetitledata)) {
            $this->load->model('staffapp/staffapp_core', 'coreObj');
            $staffnamepic = $this->coreObj->GetStaffName($noticetitledata['entry_by'], $dbObj);
            $noticetitle[] = array('ntc_id' => $notice_id, 'ntc_type' => $noticetitledata['notice_type'], 'sndr_name' => $staffnamepic['staff_name'], 'sndr_image' => $staffnamepic['staff_pic'], 'ntc_content' => $noticetitledata['notice_content'], 'ntc_date' => date("jS F,Y ", strtotime($noticetitledata['timestamp'])));
            return $noticetitle;
        } else {
            return -1;
        }
    }

    public function getEventList($dataObj) {
        $EventDetails = array();
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('id,name,on_date');
        $dbObj->where('incharge_staff_id', $dataObj['id']);
        $dbObj->limit(10);
        $event = $dbObj->get('event_details')->result_array();
        for ($i = 0; $i < count($event); $i++) {
            $team = $this->getEventTeamDetails($event[$i]['id'], $dbObj);
            $EventDetails[] = array('event_id' => $event[$i]['id'], 'event_name' => $event[$i]['name'] . "(" . $team . ")", 'strt_on' => date("jS F,Y ", strtotime($event[$i]['on_date'])));
        }
        return $EventDetails;
    }

    public function getEventTeamDetails($id, $dbObj) {
        $dbObj->select('COUNT(`id`) as totalteam');
        $count = $dbObj->get_where("event_team_detail", array('event_id' => $id))->row_array();
        if (!empty($count)) {
            return $count['totalteam'];
        } else {
            return 0;
        }
    }

    public function GetMyExamDateSchedule($examId, $dataObj) {
        $dateschedule = array();
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('a.subject_name,b.exam_date,b.exam_time,b.duration');
        $dbObj->from('subject_list as a');
        $dbObj->join('exam_datesheet_subject_relation as b', 'a.id=b.subject_id');
        $dbObj->where('b.exam_id', $examId);
        $dateschedule = $dbObj->get()->result_array();
        if (!empty($dateschedule)) {
            $exam_name = $this->GetExamName($examId, $dbObj);
            $examschedule = array('exam_name' => "Schedule of " . $exam_name, 'datesheet' => $dateschedule);
            return $examschedule;
        } else {
            return -1;
        }
    }

    public function GetExamName($examId, $dbObj) {
        $examname = $dbObj->get_where('exam_datesheet_details', array('id' => $examId))->row_array();
        return $examname['exam_name'];
    }

    public function GetCardCount($dataObj) {
        $staff_id = $dataObj['id'];
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('upper(a.card_type) as card_name,count(a.card_type) as card_count,lower(a.card_type) as card_color');
        $dbObj->from('cards_details as a');
        $dbObj->join('biodata as b', 'a.adm_no=b.adm_no');
        $dbObj->where('a.entry_by', $staff_id);
        $dbObj->where('a.approved_status', 'YES');
        $dbObj->group_by('a.card_type');
        $cardCount = $dbObj->get()->result_array();         
        foreach ($cardCount as $key => $value) {
            if ($value['card_name'] == '' || $value['card_name'] == null) {
                unset($cardCount[$key]);
            }
        }
        $cardCount = array_values($cardCount);       
        return $cardCount;
    }

    public function GetUpComingHoliday($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("holiday_reason,DATE_FORMAT(date,'%D %M, %Y') as date,DATE_FORMAT(date,'%W') as weekday", FALSE);
        $dbObj->from('session_holiday_details');
        $dbObj->where('date > now()');
        $dbObj->order_by('YEAR(`date`)');
        $dbObj->order_by('MONTH(`date`)');
        $dbObj->order_by('DAY(`date`)');
        $dbObj->limit(5);
        $holidayDeatils = $dbObj->get()->result_array();
        $arrFinalHoliday = array();
        $i = 0;
        foreach ($holidayDeatils as $val) {
            $arrHoliday = array('type' => 'HOLIDAY', 'holiday_reason' => $val['holiday_reason'], 'holidaydate' => $val['date'] . '(' . $val['weekday'] . ')');
            $arrFinalHoliday[$i] = $arrHoliday;
            $i++;
        }
        if (!empty($arrFinalHoliday)) {
            return $arrFinalHoliday;
        } else {
            return $holidayDeatils;
        }
    }

    public function GetCardDetail($card_type, $dataObj) {
        $staff_id = $dataObj['id'];
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $term = $dbObj->get("session_term_setting")->result_array();
        $startsession = $term[0]['date_from'];
        $end = $term[1]['date_to'];
        $query = "SELECT a.`id`,a.`card_type`,a.`adm_no`,a.`remarks`,a.`card_issue_date`,b.`firstname`,b.`lastname` FROM `cards_details` as a,`biodata` as b WHERE '$startsession' < a.`card_issue_date`< '$end' AND a.`card_type` = '" . strtoupper($card_type) . "' AND a.`entry_by` = '$staff_id' AND b.`adm_no` = a.`adm_no` ORDER BY a.`timestamp` DESC";

        $card = $dbObj->query($query)->result_array();
        

        for ($i = 0; $i < count($card); $i++) {

            $studentnamepic = $this->coreObj->GetStudentDetail($card[$i]['adm_no'], $dbObj);
            $cardDetails[] = array('adm_no' => $card[$i]['adm_no'], 'stu_name' => $card[$i]['firstname'] . ' ' . $card[$i]['lastname'], 'stu_pic' => base_url() . "index.php/app/getstudphoto/" . $card[$i]['adm_no'] . "/THUMB", 'card_reason' => $card[$i]['remarks'], 'card_issueon' => date("jS F Y ", strtotime($card[$i]['card_issue_date'])), 'card_issue_id' => $card[$i]['id']);
        }
        return $cardDetails;
    }

}
