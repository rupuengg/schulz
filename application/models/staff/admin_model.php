<?php

class admin_model extends CI_Model {

    public function getBlueCard() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "BLUE"))->row_array();
    }

    public function getTodayBlueCard() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "BLUE", "DATE(timestamp)" => $todaydate))->row_array();
    }

    public function getYellowCard() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "YELLOW"))->row_array();
    }

    public function getTodayYellowCard() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "YELLOW", "DATE(timestamp)" => $todaydate))->row_array();
    }

    public function getPinkCard() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "PINK"))->row_array();
    }

    public function getTodayPinkCard() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "PINK", "DATE(timestamp)" => $todaydate))->row_array();
    }

    public function getRedCard() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "RED"))->row_array();
    }

    public function getTodayRedCard() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(card_type) as count');
        return $dbObj->get_where("cards_details", array('card_type' => "RED", "DATE(timestamp)" => $todaydate))->row_array();
    }

    public function getTodayAbsentAttendance() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no');
        $adm_no = $dbObj->get_where("attendance_detail", array('att_status' => "ABSENT", "attendance_date" => $todaydate))->result_array();
        $absentArray = array();
        for ($l = 0; $l < count($adm_no); $l++) {
            $admission = $adm_no[$l]['adm_no'];
            $dbObj->select('adm_no,firstname,lastname,profile_pic_path');
            $dbObj->where('adm_no', $admission);
            $studentdetails = $dbObj->get('biodata')->row_array();

            $absentArray[] = $studentdetails;
        }
        return $absentArray;
    }

    public function getTodayPresentAttendance() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no');
        return $dbObj->get_where("attendance_detail", array('att_status' => "PRESENT", "attendance_date" => $todaydate))->result_array();
    }

    public function getTodayLateAttendance() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no');
        $adm_no = $dbObj->get_where("late_coming_details", array("coming_date" => $todaydate))->result_array();
        $lateArray = array();
        for ($l = 0; $l < count($adm_no); $l++) {
            $admission = $adm_no[$l]['adm_no'];
            $dbObj->select('adm_no,firstname,lastname,profile_pic_path');
            $dbObj->where('adm_no', $admission);
            $studentdetails = $dbObj->get('biodata')->row_array();

            $lateArray[] = $studentdetails;
        }
        return $lateArray;
    }

    public function getTodayStaffAbsentAttendance() {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('staff_id');
        $adm_no = $dbObj->get_where("staff_attendance", array("date" => $todaydate, "status" => 'ABSENT'))->result_array();
        $lateArray = array();
        for ($l = 0; $l < count($adm_no); $l++) {
            $dbObj->select('id,salutation,staff_fname,staff_lname,profile_pic_path');
            $dbObj->where('id', $adm_no[$l]['staff_id']);
            $staffdetails = $dbObj->get('staff_details')->row_array();
            $lateArray[] = $staffdetails;
        }
        return $lateArray;
    }

    public function getSectionAttendance() {
        $todaydate = date('Y-m-d');
        $givensec = ['A', 'B', 'C', 'D'];
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('CONCAT(a.standard, ' . ', a.section) AS sectionname,a.order,CONCAT(b.salutation,' . 'b.staff_fname) AS staffname,b.staff_lname,b.id', FALSE);
        $dbObj->from('section_list as a');
        $dbObj->order_by('a.order', 'asc');
        $dbObj->where('a.status', 1);
        $dbObj->join('staff_details as b', 'a.class_teacher_id = b.id', 'left');
        $dbObj->where('a.id NOT IN (SELECT `section_id` FROM `attendance_status` WHERE `att_date`="' . $todaydate . '")', NULL, FALSE);
        $section = $dbObj->get()->result_array();
        return $section;
    }

    public function getLastSevenwrkngDay() {
        $dynamicDB = $this->load->database($this->session->userdata('database'), TRUE);
        $todaydate = date('Y-m-d');
        $dateArray = array();
        while (count($dateArray) != 7) {
            $date = $todaydate;
            $dynamicDB->select('date,is_holiday');
            $getdate = $dynamicDB->get_where('session_days', array('date' => $date))->row_array();
            if (!empty($getdate)) {
                if ($getdate['is_holiday'] == 'No') {
                    $dateArray[] = $getdate['date'];
                }
            }

            $todaydate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        }
        return $dateArray;
    }

    public function getStudentloginStatus($schoolcode) {
        $dateArray = $this->getLastSevenwrkngDay();
        foreach ($dateArray as $value) {
            $this->db->select('COUNT(`id`) as totallogin');
            $this->db->from('user_login_logs');
            $this->db->where('`user_id` IN (SELECT `id` FROM `system_users` WHERE school_code = "' . $schoolcode . '" AND member_type = "PARENT")', NULL, TRUE);
            $this->db->where('login_person =', 'USER');
            $this->db->where('DATE(`timestamp`) =', $value);
            $objstddata = $this->db->get()->row_array();
            $dataArray[] = $objstddata['totallogin'];
        }
        return $dataArray;
    }

    public function getStaffloginStatus($schoolcode) {
        $dateArray = $this->getLastSevenwrkngDay();
        foreach ($dateArray as $value) {
            $this->db->select('COUNT(`id`) as totallogin');
            $this->db->from('user_login_logs');
            $this->db->where('`user_id` IN (SELECT `id` FROM `system_users` WHERE school_code = "' . $schoolcode . '" AND member_type = "STAFF")', NULL, TRUE);
            $this->db->where('login_person =', 'USER');
            $this->db->where('DATE(`timestamp`) =', $value);
            $objstddata = $this->db->get()->row_array();
            $dataArray[] = $objstddata['totallogin'];
        }
        return $dataArray;
    }

    public function getLoginGraphData($schoolcode) {
        $sevenDay = $this->getLastSevenwrkngDay();
        $studentLoginData = $this->getStudentloginStatus($schoolcode);
        $staffLoginData = $this->getStaffloginStatus($schoolcode);
        foreach ($sevenDay as $key => $val) {
            $sevenDay[$key] = date('d', strtotime($val)) . ' ' . date('D', strtotime($val));
        }
        return array('studentLogin' => $studentLoginData, 'staffLogin' => $staffLoginData, 'wrkngDay' => $sevenDay);
    }

    public function getTodayisholiday() {
        $currentDate = date('Y-m-d');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('reason,is_holiday,date');
        $dbObj->from('session_days');
        $dbObj->where('date', $currentDate);
        $objstddata = $dbObj->get()->result_array();
        return $objstddata;
    }

    public function getHoliday() {
        $currentYear = date('Y');
        $currentDate = date('Y-m-d');
        $yearEnd = date('Y-m-d', strtotime('12/31'));
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('holiday_reason,date');
        $dbObj->from('session_holiday_details');
//        $dbObj->where('YEAR(date) = ' . $currentYear . '');
        $dbObj->where('date >=', $currentDate);
//        $dbObj->where('date <=', $yearEnd);
        $dbObj->order_by("date", "asc");
        $dbObj->limit(10);
        $objstddata = $dbObj->get()->result_array();
//        echo $dbObj->last_query();
        $todaydate = date('Y-m-d');
        $allData = array();
        for ($i = 0; $i < count($objstddata); $i++) {
            $dataArray = array();
            $datetime1 = new DateTime($todaydate);
            $datetime2 = new DateTime($objstddata[$i]['date']);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            if ($days == 0) {
                $dataArray[0]['holiday_reason'] = $objstddata[$i]['holiday_reason'];
                $dataArray[0]['date'] = 'Today';
            } elseif ($days == 1) {
                $dataArray[0]['holiday_reason'] = $objstddata[$i]['holiday_reason'];
                $dataArray[0]['date'] = 'Tommorrow';
            } else {
                $dataArray[0]['holiday_reason'] = $objstddata[$i]['holiday_reason'];
                $dataArray[0]['date'] = 'In ' . $days . ' days' . ' (' . ChangeMydateFormat($objstddata[$i]['date']) . ')';
            }
            $allData = array_merge($allData, $dataArray);
        }

        return $allData;
    }

    public function updateHoliday() {
        $reason = $this->input->post('data');
        $dated = $this->input->post('date');
        $holiday = $this->input->post('holiday');
        if ($holiday == 'Yes') {
            $holidaytype = 'No';
        } else {
            $holidaytype = 'Yes';
        }

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('date', $dated);
        $dbObj->update('session_days', array("reason" => $reason, "is_holiday" => $holidaytype));
        //$dbObj->update('session_days', array(array()), array('date' => $dated));
        return TRUE;
    }

    public function GetExamDatesheet() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,exam_name,standard,section_type');
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
                        $examdatesheet[$i]['standard'] = $concateSectionName;
                    }
                }
            }
            return $examdatesheet;
        } else {
            return -1;
        }
    }

    public function GetMyExamDateSchedule($examId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.subject_name,b.exam_date,b.exam_time,b.duration');
        $dbObj->from('subject_list as a');
        $dbObj->join('exam_datesheet_subject_relation as b', 'a.id=b.subject_id');
        $dbObj->where('b.exam_id', $examId);
        $dateschedule = $dbObj->get()->result_array();
        if (!empty($dateschedule)) {
            foreach ($dateschedule as $key => $val) {
                $dateschedule[$key]['exam_date'] = ChangeMydateFormat($val['exam_date']);
                $dateschedule[$key]['exam_time'] = date('H:i', strtotime($val['exam_time']));
            }
            return $dateschedule;
        } else {
            return -1;
        }
    }

    public function getLastLoginByUserId($userid, $status) {
        $lastdate = date('Y-m-d', strtotime("-7 days"));
        $start_date = date('Y-m-d');
        $this->db->select('MAX(timestamp) as date,user_id');
        $this->db->from('user_login_logs ');
        $this->db->where('user_id ', $userid);
        if ($status) {
            $this->db->where('timestamp  BETWEEN "' . date('Y-m-d', strtotime($lastdate)) . '" and "' . date('Y-m-d', strtotime($start_date)) . '"');
        }
        $objtddata = $this->db->get_where()->row_array();
        if (!empty($objtddata)) {
            $objtddata['date'] = ChangeMydateFormat($objtddata['date']);
        }
        return $objtddata;
    }

    public function getlast7daystffNotlogged($schoolcode) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $lastdate = date('Y-m-d', strtotime("-7 days"));
        $start_date = date('Y-m-d');
        $this->db->select('staff_id,id');
        $staffidddata = $this->db->get_where('system_users', array('school_code' => $schoolcode, 'member_type' => 'STAFF'))->result_array();
        foreach ($staffidddata as $key => $idvalue) {
            $objtddata = $this->getLastLoginByUserId($idvalue['id'], TRUE);
            if (!empty($objtddata)) {
                unset($staffidddata[$key]);
                $staffidddata = array_values($staffidddata);
            }
        }
        foreach ($staffidddata as $key => $idvalue) {
            $diff = 0;
            $days = 0;
            $loggedddata = $this->getLastLoginByUserId($idvalue['id'], FALSE);
            if (!empty($loggedddata)) {
                $dbObj->select("staff_fname AS staffname,staff_lname");
                $querydata = $dbObj->get_where('staff_details', array('id' => $idvalue['staff_id']))->row_array();
                if (!empty($querydata)) {
                    if (isset($loggedddata['date'])) {
                        $diff = abs(strtotime($start_date) - strtotime($loggedddata['date']));
                        $days = floor($diff / (60 * 60 * 24));
                        $staffidddata[$key]['lastLogin'] = ChangeMydateFormat($loggedddata['date']);
                    } else {
                        $staffidddata[$key]['lastLogin'] = "User not logged yet";
                        $staffidddata[$key]['notlogged_class'] = "color:#FF0000";
                    }
                    $staffidddata[$key]['dateintrvl'] = $days;
                    $staffidddata[$key]['staffname'] = $querydata['staffname'] . ' ' . $querydata['staff_lname'];
                }
            }
        }
        return $staffidddata;
    }

}
