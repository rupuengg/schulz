<?php

class apphomepage_model extends CI_Model {

    public function GetUpComingNews($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $arrUpcomngEvent = $this->GetUpComingEvents($dataObj);
        $arrUpcomngHoliday = $this->GetUpComingHoliday($dataObj);
        $arrUpcomngExamdate = $this->GetExamDateSheet($dataObj);
        $arrFinalNews = array_merge((array) $arrUpcomngEvent, (array) $arrUpcomngHoliday,(array) $arrUpcomngExamdate);
        return $arrFinalNews;
    }

    public function GetUpComingEvents($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("name,DATE_FORMAT(on_date,'%D %M, %Y') as on_date,venue", FALSE);
        $dbObj->from('event_details');
        $dbObj->where('on_date > now()');
        $dbObj->order_by('on_date', 'asc');
        $dbObj->limit(5);
        $eventDeatils = $dbObj->get()->result_array();
        $arrFinalEvent = array();
        $i = 0;
        foreach ($eventDeatils as $row) {
            $arrEvent = array('type' => 'EVENT', "eventDeatil" => $row['name'] . ' start on ' . $row['on_date'] . ' .Venue of this event is ' . $row['venue']);
            $arrFinalEvent[$i] = $arrEvent;
            $i++;
        }
        if (!empty($arrFinalEvent)) {
            return $arrFinalEvent;
        } else {
            return $eventDeatils;
        }
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
            $arrHoliday = array('type' => 'HOLIDAY', "reason" => 'Holiday on ' . $val['date'] . '('.$val['weekday'].') due to ' . $val['holiday_reason'],'holiday_reason'=>$val['holiday_reason'],'holidaydate'=>$val['date'] . '('.$val['weekday'].')');
            $arrFinalHoliday[$i] = $arrHoliday;
            $i++;
        }
        if (!empty($arrFinalHoliday)) {
            return $arrFinalHoliday;
        } else {
            return $holidayDeatils;
        }
    }

    public function GetNotifications($dataObj) {
        $this->load->model('app/appacademics_model', 'academicObj');
        $arrMarks = $this->academicObj->LoadStudentMarks($dataObj);
        $this->load->model('app/appevent_model', 'eventObj');
        $arrEvent = $this->eventObj->GetAllEventsDetails($dataObj);
        $this->load->model('app/appcard_model', 'cardObj');
        $arrCard = $this->cardObj->GetCardDetails($dataObj);
        $arrFinal = array();
        $arrFinal['marks'] = $arrMarks;
        $arrFinal['card'] = $arrCard;
        $arrFinal['event'] = $arrEvent;
        return $arrFinal;
    }

    public function GetExamDateSheet($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("exam_name,DATE_FORMAT(exam_publish_date,'%D %M, %Y') as exam_publish_date", FALSE);
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->limit(5);
        $examDate = $dbObj->get_where('exam_datesheet_details', array('exam_publish_date <=' => date('Y-m-d'), 'standard' => $dataObj['class']))->result_array();
        $arrFinalExamDate = array();
        $i = 0;
        foreach ($examDate as $row) {
            $arrExam = array('type' => 'DATESHEET', "reason" => $row['exam_name'] . ' datesheet avilable now');
            $arrFinalExamDate[$i] = $arrExam;
            $i++;
        }
        if (!empty($arrFinalExamDate)) {
            return $arrFinalExamDate;
        } else {
            return $examDate;
        }
    }

}
