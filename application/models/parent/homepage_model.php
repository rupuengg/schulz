<?php

class homepage_model extends CI_Model {

    public function GetUpComingNews() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $arrUpcomngEvent = $this->GetUpComingEvents();
        $arrUpcomngHoliday = $this->GetUpComingHoliday();
        $arrUpcomngExamdate = $this->GetExamDateSheet();
        $arrFinalNews = array_merge((array) $arrUpcomngEvent, (array) $arrUpcomngHoliday, (array) $arrUpcomngExamdate);
        return $arrFinalNews;
    }

    public function GetUpComingEvents() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("name,DATE_FORMAT(on_date,'%d- %m- %Y') as on_date,venue", FALSE);
        $dbObj->from('event_details');
        $dbObj->where('on_date > now()');
        $dbObj->order_by('on_date', 'asc');
        $dbObj->limit(5);
        $eventDeatils = $dbObj->get()->result_array();
        $arrFinalEvent = array();
        $i = 0;
        foreach ($eventDeatils as $row) {
            $arrEvent = array();
            $arrEvent['type'] = 'EVENT';
            $arrEvent['data'] = array("name" => $row['name'], "date" => $row['on_date'], "venue" => $row['venue']);
            $arrFinalEvent[$i] = $arrEvent;
            $i++;
        }
        if (!empty($arrFinalEvent)) {
            return $arrFinalEvent;
        } else {
            return $arrFinalEvent;
        }
    }

    public function GetUpComingHoliday() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
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
            $arrHoliday = array();
            $arrHoliday['type'] = 'HOLIDAY';
            $arrHoliday['data'] = array("holiday_reason" => $val['holiday_reason'], "date" => $val['date'], "weekday" => $val['weekday']);
            $arrFinalHoliday[$i] = $arrHoliday;
            $i++;
        }
        if (!empty($arrFinalHoliday)) {
            return $arrFinalHoliday;
        } else {
            return $arrFinalHoliday;
        }
    }

    public function GetNotifications() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/academics_model', 'academicObj');
        $arrMarks = $this->academicObj->LoadStudentMarks($dataObj);
        $this->load->model('parent/events_model', 'eventObj');
        $arrEvent = $this->eventObj->GetAllEventsDetails($dataObj);
        $this->load->model('parent/card_model', 'cardObj');
        $arrCard = $this->cardObj->GetCardDetails($dataObj);
        $arrFinal = array();
        $arrFinal['marks'] = $arrMarks;
        $arrFinal['card'] = $arrCard;
        $arrFinal['event'] = $arrEvent;
        return $arrFinal;
    }

    public function GetExamDateSheet() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("exam_name,DATE_FORMAT(exam_publish_date,'%d-%m-%Y') as exam_publish_date", FALSE);
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->limit(5);
        $examDate = $dbObj->get_where('exam_datesheet_details', array('exam_publish_date <=' => date('Y-m-d'), 'standard' => $dataObj['class']))->result_array();
        $arrFinalExamDate = array();
        $i = 0;
        foreach ($examDate as $row) {
            $arrExam = array();
            $arrExam['type'] = 'DATESHEET';
            $arrExam['data'] = array("exam_name" => $row['exam_name'], "publish_date" => $row['exam_publish_date']);
            $arrFinalExamDate[$i] = $arrExam;
            $i++;
        }
        if (!empty($arrFinalExamDate)) {
            return $arrFinalExamDate;
        } else {
            return $arrFinalExamDate;
        }
    }

}
