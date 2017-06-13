<?php

class appnotification_model extends CI_Model {

    public function GetAllNotifications($dataObj) {
        $attstaus['0'] = $this->attendanseStatus($dataObj);
        $countcard = $this->cardStats($dataObj);
        $countlib['2'] = $this->statsLibrary($dataObj);
        $countact['3'] = $this->statsEvent($dataObj);
        $upcomingholiday = $this->UpComingHoliday($dataObj);
        $upcomingevent = $this->UpComingEvents($dataObj);
        $notifactionMarks = $this->GetMarksNotifications($dataObj);
        $examdatesheet = $this->ExamDateSheet($dataObj);
        $librarydata = $this->libraryBookDetail($dataObj);
        $ccgrade = $this->ccGrade($dataObj);
        $club = $this->clubData($dataObj);
        $card = $this->cardDetail($dataObj);
        $arrFinal['notification'] = array_merge($upcomingholiday, $upcomingevent, $notifactionMarks, $librarydata, $card, $club, $ccgrade, $examdatesheet);
        $arrFinal['stats'] = array_merge($attstaus, $countlib, $countact);
        $arrFinal['cardStats'] = array($countcard);
        if($arrFinal){
            return $arrFinal;
        }else {
            return array();
        }
        
    }

    public function UpComingHoliday($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("holiday_reason,timestamp,DATE_FORMAT(date,'%D %M, %Y') as date,DATE_FORMAT(date,'%W') as weekday,", FALSE);
        $dbObj->from('session_holiday_details');
        $dbObj->where('date > now()');
        $dbObj->order_by('YEAR(`date`)');
        $dbObj->order_by('MONTH(`date`)');
        $dbObj->order_by('DAY(`date`)');
        $dbObj->limit(10);
        $holidayDeatils = $dbObj->get()->result_array();
        $arrFinalHoliday = array();
        $i = 0;
        foreach ($holidayDeatils as $val) {
            $arrHoliday = array('type' => 'HOLIDAY', "remarks" => 'School is closed on ' . $val['date'] . ' cause of ' . $val['holiday_reason'], "timestamp" => $val['timestamp'], "weekday" => $val['weekday']);
            $arrFinalHoliday[$i] = $arrHoliday;
            $i++;
        }
        if (!empty($arrFinalHoliday)) {
            return $arrFinalHoliday;
        } else {
            return array();
        }
    }

    public function UpComingEvents($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("name,timestamp,DATE_FORMAT(on_date,'%D %M, %Y') as on_date,venue", FALSE);
        $dbObj->from('event_details');
        $dbObj->where('on_date > now()');
        $dbObj->order_by('on_date', 'asc');
        $dbObj->limit(10);
        $eventDeatils = $dbObj->get()->result_array();
        $arrFinalEvent = array();
        $i = 0;
        foreach ($eventDeatils as $row) {
            $arrEvent = array('type' => 'EVENT', "remarks" => $row['name'] . ' is scheduled on ' . $row['on_date'] . ' at ' . $row['venue'], "timestamp" => $row['timestamp']);
            $arrFinalEvent[$i] = $arrEvent;
            $i++;
        }
        if (!empty($arrFinalEvent)) {
            return $arrFinalEvent;
        } else {
            return array();
        }
    }

    public function GetMarksNotifications($dataObj) {
        $this->load->model('app/appacademics_model', 'academicObj');
        $arrMarks = $this->academicObj->LoadStudentMarks($dataObj);
        if (!empty($arrMarks)) {
            return $arrMarks;
        } else {
             return array();
        }
    }

    public function ExamDateSheet($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("exam_name,timestamp,DATE_FORMAT(exam_publish_date,'%D %M,%Y') as exam_publish_date", FALSE);
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->limit(10);
        $examDate = $dbObj->get_where('exam_datesheet_details', array('exam_publish_date <=' => date('Y-m-d'), 'standard' => $dataObj['class']))->result_array();
        $arrFinalExamDate = array();
        $i = 0;
        foreach ($examDate as $row) {
            $arrExam = array('type' => 'DATESHEET', "remarks" => 'Datesheet of ' . $row['exam_name'] . ' is available now. ', "timestamp" => $row['timestamp']);
            $arrFinalExamDate[$i] = $arrExam;
            $i++;
        }
        if (!empty($arrFinalExamDate)) {
            return $arrFinalExamDate;
        } else {
             return array();
        }
    }

    public function libraryBookDetail($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("DATE_FORMAT(a.issue_date,'%D %M,%Y') as issue_date,a.timestamp,DATE_FORMAT(a.due_date,'%D %M,%Y') as due_date,b.book_name", FALSE);
        $dbObj->from('lms_book_issue_detail as a');
        $dbObj->join('lms_book_details as b', 'a.book_id=b.book_no');
        $dbObj->where('a.adm_no', $dataObj['adm_no']);
        $dbObj->where('a.status', 'ISSUED');
        $dbObj->order_by('issue_date', 'desc');
        $dbObj->limit(10);
        $libdetail = $dbObj->get()->result_array();
        $arrFinallibdetail = array();
        $i = 0;
        if (!empty($libdetail)) {
            foreach ($libdetail as $row) {
                $arrlib = array('type' => 'LIBRARY', "remarks" => 'Book of ' . $row['book_name'] . ' is issued on' . $row['issue_date'] . 'and due date is' . $row['due_date'] . ' . ', "timestamp" => $row['timestamp']);
                $arrFinallibdetail[$i] = $arrlib;
                $i++;
            }
            return $arrFinallibdetail;
        } else {
            return array();
        }
    }

    public function cardDetail($dataObj) {
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("remarks,DATE_FORMAT(card_issue_date,'%D %M,%Y') as issue_date,card_type,entry_by,timestamp", FALSE);
        $dbObj->order_by('timestamp', 'desc');
        $cardDetails = $dbObj->get_where('cards_details', array('adm_no' => $dataObj['adm_no'], 'approved_status' => 'YES'))->result_array();
        $arrFinalCardDetails = array();
        $i = 0;
        if (!empty($cardDetails)) {
            foreach ($cardDetails as $row) {
                $staff_id = $row['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id, $dbObj);
                $arrCard = array('type' => 'CARD', 'card_type' => $row['card_type'], 'remarks' => 'Got the ' . $row['card_type'] . ' card for ' . $row['remarks'] . ' on ' . $row['issue_date'], 'timestamp' => $row['timestamp']);
                $arrFinalCardDetails[$i] = $arrCard;
                $i++;
            }
            return $arrFinalCardDetails;
        } else {
            return array();
        }
    }

    public function clubData($dataObj) {
        $todaydate = date('Y-m-d');
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("DATE_FORMAT(b.meeting_date,'%D %M,%Y') as meeting_date,b.venue,b.meeting_agenda,b.timestamp", FALSE);
        $dbObj->from('club_member as a');
        $dbObj->join('club_meetings as b', 'a.club_id=b.club_id');
        $dbObj->where('a.adm_no', $dataObj['adm_no']);
        $dbObj->where('b.meeting_date >=', $todaydate);
        $clubdetail = $dbObj->get()->result_array();
        $arrFinalclubdetail = array();
        $i = 0;
        if (!empty($clubdetail)) {
            foreach ($clubdetail as $row) {
                $arrClub = array('type' => 'CLUB', 'remarks' => 'Meeting is scheduled on ' . $row['meeting_date'] . ' at ' . $row['venue'] . ' and meeting agenda is ' . $row['meeting_agenda'], 'timestamp' => $row['timestamp']);
                $arrFinalclubdetail[$i] = $arrClub;
                $i++;
            }
            return $arrFinalclubdetail;
        } else {
            return array();
        }
    }

    public function ccGrade($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj->select('cce_grades_di.di,cce_grade_setting.grade,cce_grades_di.term,cce_grades_di.entry_by,cce_grades_di.timestamp,cce_list.caption_show');
        $dbObj->from('cce_list');
        $dbObj->join('cce_grades_di', 'cce_list.id=cce_grades_di.cce_id');
        $dbObj->join('cce_grade_setting', 'cce_grades_di.grade=cce_grade_setting.id');
        $dbObj->where('cce_grades_di.adm_no', $dataObj['adm_no']);
        $dbObj->limit(10);
        $grades = $dbObj->get()->result_array();
        $arrFinalCCE = array();
        $i = 0;
        if (!empty($grades)) {
            foreach ($grades as $row) {
                $staff_detail = $this->coreObj->GetStaffName($row['entry_by'], $dbObj);
                $arrCCE = array('type' => 'CCEGRADE', 'timestamp' => $row['timestamp'], 'remarks' => $row['caption_show'] . ':TERM' . $row['term'] . '-' . $row['grade'], 'staff_name' => $staff_detail['name']);
                $arrFinalCCE[$i] = $arrCCE;
                $i++;
            }
            return $arrFinalCCE;
        } else {
             return array();
        }
    }

    public function attendanseStatus($dataObj) {
        $month_names = array("April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March");
        $this->load->model('app/appattendance_model', 'sat');
        $resultcheck = $this->sat->GetSummary($dataObj);
        $curenmonth = array_search(date('F'), $month_names);
        $totalday = 0;
        $totalAbsent = 0;
        for ($i = 0; $i <= $curenmonth; $i++) {
            $presnt = explode('/', $resultcheck['fullSummary'][$i]['total_present']);
            $totalday = $totalday + $presnt[1];
            $totalAbsent = $totalAbsent + count($resultcheck['fullSummary'][$i]['absent_summary']);
        }
        $abesentSummary = array('totalWorkingDay' => $totalday, 'totalAbsent' => $totalAbsent, 'totalpresent' => $resultcheck['shortSummary']['totPresent']);
        return $abesentSummary;
    }

    public function cardStats($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('lower(card_type) as card_name,count(card_type) as count');
        $dbObj->from('cards_details');
        $dbObj->where('adm_no', $dataObj['adm_no']);
        $dbObj->where('approved_status', 'YES');
        $dbObj->group_by('card_type');
        $dbObj->limit(10);
        $cardCount = $dbObj->get()->result_array();
        $cardCount['type'] = "CARDCOUNT";
        $cardCount['studentName'] = ucfirst(strtolower($dataObj['firstname'])) . ' ' . ucfirst(strtolower($dataObj['lastname'])) . " 's Cards ";
        if (!empty($cardCount)) {
            return $cardCount;
        } else {
             return array();
        }
    }

    public function statsLibrary($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('count(id) as countissued');
        $countissued = $dbObj->get_where('lms_book_issue_detail', array('adm_no' => $dataObj['adm_no'], 'status' => 'ISSUED'))->row_array();
        $dbObj->select('count(id) as countlost');
        $countlost = $dbObj->get_where('lms_book_issue_detail', array('adm_no' => $dataObj['adm_no'], 'status' => 'LOST'))->row_array();
        $type['type'] = "LIBRARY";
        $attstatu['type'] = $type;
        $final = array_merge($attstatu['type'], $countissued, $countlost);
        return $final;
    }

    public function statsEvent($dataObj) {
        $currentdate = date('Y-m-d');
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('count(a.role) as countevent');
        $dbObj->from('event_team_member as a');
        $dbObj->join('event_details as b', 'a.event_id = b.id');
        $dbObj->where('b.on_date <', $currentdate);
        $dbObj->where('a.adm_no', $dataObj['adm_no']);
        $dbObj->limit(10);
        $countact = $dbObj->get()->row_array();
        $dbObj->select('count(name) as counttotalevent');
        $countotalevent = $dbObj->get_where('event_details', array('on_date <' => $currentdate))->row_array();
        $type['type'] = "EVENT DETAIL";
        $attstatu['type'] = $type;
        $final = array_merge($attstatu['type'], $countact, $countotalevent);
        return $final;
    }

}
