<?php

class notification_model extends CI_Model {

    public function GetAllNotifications() {
        $attstaus['0'] = $this->attendanseStatus();
        $countcard = $this->cardStats();
        $countlib['2'] = $this->statsLibrary();
        $countact['3'] = $this->statsEvent();
        $upcomingholiday = $this->UpComingHoliday();
        $upcomingevent = $this->UpComingEvents();
        $notifaction = $this->GetNotifications();
        $examdatesheet = $this->ExamDateSheet();
        $librarydata = $this->libraryBookDetail();
        $ccgrade = $this->ccGrade();
        $club = $this->clubData();
        $card = $this->cardDetail();
        $arrFinal['notification'] = array_merge($upcomingholiday, $upcomingevent, $notifaction, $librarydata, $card, $club, $ccgrade, $examdatesheet);
        $arrFinal['stats'] = array_merge($attstaus, $countlib, $countact);
        $arrFinal['cardStats'] = $countcard;
        return $arrFinal;
    }

    public function UpComingHoliday() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
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
            $arrHoliday = array();
            $arrHoliday['type'] = 'HOLIDAY';
            $arrHoliday['timestamp'] = $val['timestamp'];
            $arrHoliday['data'] = array("holiday_reason" => $val['holiday_reason'], "date" => $val['date'], "timestamp" => $val['timestamp'], "weekday" => $val['weekday']);
            $arrFinalHoliday[$i] = $arrHoliday;
            $i++;
        }
        if (!empty($arrFinalHoliday)) {
            return $arrFinalHoliday;
        } else {
            $arr = array("null" => 0);
            return array();
        }
    }

    public function UpComingEvents() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("name,timestamp,DATE_FORMAT(on_date,'%d- %m- %Y') as on_date,venue", FALSE);
        $dbObj->from('event_details');
        $dbObj->where('on_date > now()');
        $dbObj->order_by('on_date', 'asc');
        $eventDeatils = $dbObj->get()->result_array();
        $arrFinalEvent = array();
        $i = 0;
        foreach ($eventDeatils as $row) {
            $arrEvent = array();
            $arrEvent['type'] = 'EVENT';
            $arrEvent['timestamp'] = $row['timestamp'];
            $arrEvent['data'] = array("name" => $row['name'], "date" => $row['on_date'], "venue" => $row['venue']);
            $arrFinalEvent[$i] = $arrEvent;
            $i++;
        }
        if (!empty($arrFinalEvent)) {
            return $arrFinalEvent;
        } else {
            $arr = array("null" => 0);
            return array();
        }
    }

    public function GetNotifications() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/academics_model', 'academicObj');
        $arrMarks = $this->academicObj->LoadStudentMarks($dataObj);
        if (!empty($arrMarks)) {
            return $arrMarks;
        } else {
            $arr = array("null" => 0);
            return array();
        }
        
    }

    public function ExamDateSheet() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("exam_name,timestamp,DATE_FORMAT(exam_publish_date,'%d-%m-%Y') as exam_publish_date", FALSE);
        $dbObj->order_by('timestamp', 'desc');
        $examDate = $dbObj->get_where('exam_datesheet_details', array('exam_publish_date <=' => date('Y-m-d'), 'standard' => $dataObj['class']))->result_array();
        $arrFinalExamDate = array();
        $i = 0;
        foreach ($examDate as $row) {
            $arrExam = array();
            $arrExam['type'] = 'DATESHEET';
            $arrExam['timestamp'] = $row['timestamp'];
            $arrExam['data'] = array("exam_name" => $row['exam_name'], "publish_date" => $row['exam_publish_date']);
            $arrFinalExamDate[$i] = $arrExam;
            $i++;
        }
        if (!empty($arrFinalExamDate)) {
            return $arrFinalExamDate;
        } else {
            $arr = array("null" => 0);
            return array();
        }
    }

    public function libraryBookDetail() {
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("DATE_FORMAT(a.issue_date,'%d-%m-%Y') as issue_date,a.timestamp,DATE_FORMAT(a.due_date,'%d-%m-%Y') as due_date,b.book_name", FALSE);
        $dbObj->from('lms_book_issue_detail as a');
        $dbObj->join('lms_book_details as b', 'a.book_id=b.book_no');
        $dbObj->where('a.adm_no', $adm_no);
        $dbObj->where('a.status', 'ISSUED');
        $libdetail = $dbObj->get()->result_array();
        $arrFinallibdetail = array();
        $i = 0;
        if (!empty($libdetail)) {
            foreach ($libdetail as $row) {
                $arrlib['timestamp'] = $row['timestamp'];
                $arrlib['type'] = 'LIBRARY DETAIL';
                $arrlib['data'] = array('issue_date' => $row['issue_date'], 'due_date' => $row['due_date'], 'book_name' => $row['book_name']);
                $arrFinallibdetail[$i] = $arrlib;
                $i++;
            }
            return $arrFinallibdetail;
        } else {
            $arr = array("null" => 0);
            return array();
        }
    }

    public function cardDetail() {
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("remarks,DATE_FORMAT(card_issue_date,'%D %M,%Y') as issue_date,card_type,entry_by,timestamp", FALSE);
        $dbObj->order_by('timestamp', 'desc');
        $cardDetails = $dbObj->get_where('cards_details', array('adm_no' => $adm_no, 'approved_status' => 'YES'))->result_array();
        $arrFinalCardDetails = array();
        $i = 0;
        if (!empty($cardDetails)) {
            foreach ($cardDetails as $row) {
                $staff_id = $row['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id);
                $arrCard = array();
                $arrCard['timestamp'] = $row['timestamp'];
                $arrCard['type'] = 'CARD';
                $arrCard['data'] = array('card_type' => $row['card_type'], 'remark' => $row['remarks'], 'issue_date' => $row['issue_date'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id']);
                $arrFinalCardDetails[$i] = $arrCard;
                $i++;
            }
            return $arrFinalCardDetails;
        } else {
            $arr = array("null" => 0);
            return array();
        }
    }

    public function clubData() {
        $todaydate = date('Y-m-d');
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("DATE_FORMAT(b.meeting_date,'%D-%M-%Y') as meeting_date,b.venue,b.meeting_agenda,b.timestamp", FALSE);
        $dbObj->from('club_member as a');
        $dbObj->join('club_meetings as b', 'a.club_id=b.club_id');
        $dbObj->where('a.adm_no', $adm_no);
        $dbObj->where('b.meeting_date >=', $todaydate);
        $clubdetail = $dbObj->get()->result_array();
        $arrFinalclubdetail = array();
        $i = 0;
        if (!empty($clubdetail)) {
            foreach ($clubdetail as $row) {
                $arrClub['timestamp'] = $row['timestamp'];
                $arrClub['type'] = 'CLUB MEETING';
                $arrClub['data'] = array('meetingdate' => $row['meeting_date'], 'venue' => $row['venue'], 'meetingagenda' => $row['meeting_agenda']);
                $arrFinalclubdetail[$i] = $arrClub;
                $i++;
            }
            return $arrFinalclubdetail;
        } else {
            return array();
        }
    }

    public function ccGrade() {
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select('cce_grades_di.di,cce_grade_setting.grade,cce_grades_di.term,cce_grades_di.entry_by,cce_grades_di.timestamp,cce_list.caption_show');
        $dbObj->from('cce_list');
        $dbObj->join('cce_grades_di', 'cce_list.id=cce_grades_di.cce_id');
        $dbObj->join('cce_grade_setting', 'cce_grades_di.grade=cce_grade_setting.id');
        $dbObj->where('cce_grades_di.adm_no', $adm_no);
        $grades = $dbObj->get()->result_array();
        $arrFinalCCE = array();
        $i = 0;
        if (!empty($grades)) {
            foreach ($grades as $row) {
                $arrCCE = array();
                $staff_id = $row['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id);
                $arrCCE['timestamp'] = $row['timestamp'];
                $arrCCE['type'] = 'CCEGRADE';
                $arrCCE['data'] = array('di' => $row['di'], 'grade' => $row['grade'], 'term' => $row['term'], 'staff_name' => $staff_detail['name'], 'cce_name' => $row['caption_show'], 'staff_id' => $staff_detail['id']);
                $arrFinalCCE[$i] = $arrCCE;
                $i++;
            }
            return $arrFinalCCE;
        } else {
            $arr = array("null" => 0);
            return array();
        }
    }

    public function attendanseStatus() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/attendance_model', 'sat');
        $resultcheck = $this->sat->GetSummary($dataObj);
        $curenmonth = date('F');
        $totalday = 0;
          $toatalabsent=0;
        for ($i = 0;; $i++) {
          
            if ($resultcheck['fullSummary'][$i]['month'] != $curenmonth) {
                $totalday = $totalday + $resultcheck['fullSummary'][$i]['total_working_days'];
                $absent = count($resultcheck['fullSummary'][$i]['absent_summary']);
                $toatalabsent = $toatalabsent + $absent;
            } else {
                goto bye;
            }
        }
        bye:
        $type['type'] = "ATTENDANCE DETAIL";
        $attstatu['type'] = $type;
        $tempattstatu['totalday'] = $totalday;
        $attstatu['totalday'] = $tempattstatu;
        $tempattstatu['totalabsent'] = $toatalabsent;
        $attstatu['totalabsent'] = $tempattstatu;
        $attstatutemp['totalpresent'] = $resultcheck['shortSummary']['totPresent'];
        $attstatu['totalpresent'] = $attstatutemp;
        $final = array_merge($attstatu['totalday'], $attstatu['totalabsent'], $attstatu['type'], $attstatu['totalpresent']);

        return $final;
    }

    public function cardStats() {
        $cardCount['type'] = "CARD DETAIL";
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('lower(card_type) as card_name,count(card_type) as count');
        $dbObj->from('cards_details');
        $dbObj->where('adm_no', $adm_no);
        $dbObj->where('approved_status', 'YES');
        $dbObj->group_by('card_type');
        $cardCount = $dbObj->get()->result_array();
        if (!empty($cardCount)) {
            return $cardCount;
        } else {
            $arr = array("null" => 0);
            return array();
        }
    }

    public function statsLibrary() {
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as countissued');
        $countissued = $dbObj->get_where('lms_book_issue_detail', array('adm_no' => $adm_no, 'status' => 'ISSUED'))->row_array();
        $dbObj->select('count(id) as countlost');
        $countlost = $dbObj->get_where('lms_book_issue_detail', array('adm_no' => $adm_no, 'status' => 'LOST'))->row_array();
        $type['type'] = "LIBRARY DETAIL";
        $attstatu['type'] = $type;
        $final = array_merge($attstatu['type'], $countissued, $countlost);
        return $final;
    }

    public function statsEvent() {
        $currentdate = date('Y-m-d');
        $adm_no = $this->session->userdata('current_adm_no');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(a.role) as countevent');
        $dbObj->from('event_team_member as a');
        $dbObj->join('event_details as b', 'a.event_id = b.id');
        $dbObj->where('b.on_date <', $currentdate);
        $dbObj->where('a.adm_no', $adm_no);
        $countact = $dbObj->get()->row_array();
        $dbObj->select('count(name) as counttotalevent');
        $countotalevent = $dbObj->get_where('event_details', array('on_date <' => $currentdate))->row_array();
        $type['type'] = "EVENT DETAIL";
        $attstatu['type'] = $type;
        $final = array_merge($attstatu['type'], $countact, $countotalevent);
        return $final;
    }

}
