<?php

class holiday_model extends CI_Model {

    public function MarkSingleDayOpenOrClose($date, $reason, $is_holiday) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);

        if ($is_holiday == 'Yes') {
            $arrHolidayInsert = array("holiday_reason" => $reason, "date" => $date);
            $SessionUpdate = array("reason" => $reason, "is_holiday" => $is_holiday);
            $dbObj->where('date', $date);
            $dbObj->update('session_days', $SessionUpdate);
            $dbObj->delete('session_holiday_details', array('date' => $date));
            $dbObj->insert('session_holiday_details', $arrHolidayInsert);
            return true;
        } else {
            $SessionUpdate = array("reason" => $reason, "is_holiday" => $is_holiday);
            $dbObj->where('date', $date);
            $dbObj->update('session_days', $SessionUpdate);
            $dbObj->delete('session_holiday_details', array('date' => $date));
            return false;
        }
    }

    public function GetHolidayDetails() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('holiday_reason,date,holiday_type');
        $dbObj->from('session_holiday_details');
        $myTempHoliday = $dbObj->get()->result_array();
        return $myTempHoliday;
    }

    public function CheckHoliday($HolidayDetail, $start) {
        foreach ($HolidayDetail as $val) {
            if ($val['date'] == $start) {
                $data = array("date" => $start, "reason" => $val['holiday_reason'], "is_holiday" => 'Yes');
                return $data;
            }
        }
    }

    public function DecLargeHolidayModel($dataArr) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $start = $dataArr['holiday_sdate'];
        $end = $dataArr['holiday_edate'];
        while (strtotime($start) <= strtotime($end)) {
            $HolArr[] = array('holiday_reason' => $dataArr['holiday_reason'], 'date' => $start);
            $SessionDaysUpdate = array("date" => $start, "reason" => $dataArr['holiday_reason'], "is_holiday" => 'Yes');
            $dbObj->where('date', $start);
            $dbObj->update('session_days', $SessionDaysUpdate);
            $start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
        }
        if (count($HolArr) > 0) {
            $dbObj->insert_batch('session_holiday_details', $HolArr);
            if ($dbObj->affected_rows() == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function saveTermSession($myArr) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($myArr['t1_sdate'] !== '' || $myArr['t1_edate'] !== '' || $myArr['t2_sdate'] !== '' || $myArr['t2_edate'] !== '') {
            $HolidayDetail = $this->GetHolidayDetails();

            $dataArray = array("term1frm" => $myArr['t1_sdate'], "term1to" => $myArr['t1_edate'], "term2frm" => $myArr['t2_sdate'], "term2to" => $myArr['t2_edate'], "saturday" => isset($myArr['sat']) ? isset($myArr['sat']) : false, "sunday" => isset($myArr['sun']) ? isset($myArr['sun']) : false);
            $dataTerm1 = array(
                'date_from' => $myArr['t1_sdate'],
                'date_to' => $myArr['t1_edate'],
                'item' => 'TERM1',
                'entry_by' => $this->session->userdata('staff_id')
            );
            $dataTerm2 = array(
                'date_from' => $myArr['t2_sdate'],
                'date_to' => $myArr['t2_edate'],
                'item' => 'TERM2',
                'entry_by' => $this->session->userdata('staff_id')
            );
            $finalArray = array();
            $start = $myArr['t1_sdate'];
            $end = $myArr['t2_edate'];
            while ($start <= $end) {
                $resultTemp = $this->CheckHoliday($HolidayDetail, $start);
                $day = date('l', strtotime($start));
                if ($resultTemp == true) {
                    $datafinal = $resultTemp;
                } else {
                    if ($dataArray['saturday'] == true && $dataArray['sunday'] == false) {
                        if ($days = date('l', strtotime($start)) == 'Saturday') {
                            $datafinal = array("date" => $start, "reason" => $day, "is_holiday" => 'Yes');
                        } else {
                            $datafinal = array("date" => $start, "reason" => $day, "is_holiday" => 'No');
                        }
                    } else if ($dataArray['sunday'] == true && $dataArray['saturday'] == false) {
                        if ($days = date('l', strtotime($start)) == 'Sunday') {
                            $datafinal = array("date" => $start, "reason" => $day, "is_holiday" => 'Yes');
                        } else {
                            $datafinal = array("date" => $start, "reason" => $day, "is_holiday" => 'No');
                        }
                    } else if ($dataArray['saturday'] == true && $dataArray['sunday'] == true) {

                        if ($days = date('l', strtotime($start)) == 'Saturday' || $days = date('l', strtotime($start)) == 'Sunday') {
                            $datafinal = array("date" => $start, "reason" => $day, "is_holiday" => 'Yes');
                        } else {
                            $datafinal = array("date" => $start, "reason" => $day, "is_holiday" => 'No');
                        }
                    } else {
                        $datafinal = array("date" => $start, "reason" => $day, "is_holiday" => 'No');
                    }
                }
                $start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
                $finalArray[] = $datafinal;
            }
            if (count($dataTerm1) && count($dataTerm2)) {
                $dbObj->truncate('session_term_setting');
                $dbObj->insert('session_term_setting', $dataTerm1);
                $dbObj->insert('session_term_setting', $dataTerm2);
                if (count($finalArray) > 0) {
                    $dbObj->truncate('session_days');
                    $dbObj->insert_batch('session_days', $finalArray);
                }
                if ($dbObj->affected_rows() == 0) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return "INVALID";
        }
    }

    public function getHolidaytermDetail() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("DATE_FORMAT(`date_from`,'%d-%m-%Y') as t1_sdate,DATE_FORMAT(`date_to`,'%d-%m-%Y') as t1_edate,item", FALSE);
        $result = $dbObj->get('session_term_setting')->result_array();

        if ($result) {
            return array('t1_sdate' => $result[0]['t1_sdate'], 't1_edate' => $result[0]['t1_edate'], 't2_sdate' => $result[1]['t1_sdate'], 't2_edate' => $result[1]['t1_edate'], 'sun' => true);
        } else {
            return array('t1_sdate' => '', 't1_edate' => '', 't2_sdate' => '', 't2_edate' => '');
        }
    }

}

?>
