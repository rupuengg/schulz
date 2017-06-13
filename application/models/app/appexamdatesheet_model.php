<?php

class appexamdatesheet_model extends CI_Model {

    public function GetExamDateSheet($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('a.id,a.exam_name,a.exam_publish_date');
        $dbObj->from('exam_datesheet_details as a');
        $dbObj->join('exam_datesheet_section_relation as b', 'a.id=b.exam_id');
        $dbObj->where('b.section_id', $dataObj['section_id']);
        $dateSheet = $dbObj->get()->result_array();
        $arrFinalExamDate = array();
        $i = 0;
        if (!empty($dateSheet)) {
            for ($i = 0; $i < count($dateSheet); $i++) {
                $start_date = $this->GetStartDateOfExam($dateSheet[$i]['id'], $dbObj);
                $end_date = $this->GetEndDateOfExam($dateSheet[$i]['id'], $dbObj);
                $arrExam[] = array('type' => 'DATESHEET',"exam_Id" => $dateSheet[$i]['id'], "datesheet" => $dateSheet[$i]['exam_name'] . ' from ' . $start_date . ' to ' . $end_date);
            }
            return $arrExam;
        } else {
            return array();
        }
    }

    public function GetStartDateOfExam($exam_id, $dbObj) {
        $dbObj->select("DATE_FORMAT(`exam_date`, '%D %M, %Y') as date, DATE_FORMAT(`exam_date`, '%W') as weekday", FALSE);
        $dbObj->from('`exam_datesheet_subject_relation`');
        $dbObj->where('`exam_id`', $exam_id);
        $dbObj->order_by('YEAR(`exam_date`)');
        $dbObj->order_by('MONTH(`exam_date`)');
        $dbObj->order_by('DAY(`exam_date`)');
        $dbObj->limit(1);
        $start_Date = $dbObj->get()->row_array();
        if (!empty($start_Date)) {
            $start_Date = $start_Date['date'];
            return $start_Date;
        } else {
            return -1;
        }
    }

    public function GetEndDateOfExam($exam_id, $dbObj) {
        $dbObj->select("DATE_FORMAT(`exam_date`,'%D %M, %Y') as date,DATE_FORMAT(`exam_date`,'%W') as weekday", FALSE);
        $dbObj->from('exam_datesheet_subject_relation');
        $dbObj->where('exam_id', $exam_id);
        $dbObj->order_by('YEAR(`exam_date`)', 'desc');
        $dbObj->order_by('MONTH(`exam_date`)', 'desc');
        $dbObj->order_by('DAY(`exam_date`)', 'desc');
        $dbObj->limit(1);
        $end_date = $dbObj->get()->row_array();
        if (!empty($end_date)) {
            $end_date = $end_date['date'];
            return $end_date;
        } else {
            return -1;
        }
    }

    public function GetMyexamdateSheet($dataObj, $exam_id) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select("DATE_FORMAT(a.exam_date,'%d/%m/%Y') as examDate,a.duration,a.exam_time,b.subject_name", FALSE);
        $dbObj->from('exam_datesheet_subject_relation as a');
        $dbObj->join('subject_list as b', 'a.subject_id=b.id');
        $dbObj->where('a.exam_id', $exam_id);
        $myDateSheet = $dbObj->get()->result_array();
        if (!empty($myDateSheet)) {
            return $myDateSheet;
        } else {
            return array();
        }
    }

}
