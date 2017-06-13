<?php

class attendance_model extends CI_Model {

    public function getsectionlist() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,standard,section');
        $details = $dbObj->get_where("section_list")->result_array();
        return $details;
    }

    public function GetAbsentData($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $term = $this->coreObj->GetTermDate();
        $session_sdate = $term[0]['date_from'];
        $session_edate = $term[1]['date_to'];
        $dbObj->select('attendance_date,reason,entry_by,timestamp');
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->where('adm_no', $dataObj['adm_no']);
        $dbObj->where('att_status', 'ABSENT');
        $dbObj->where('attendance_date >=', $session_sdate);
        $dbObj->where('attendance_date <=', $session_edate);
        $arrAbsent = $dbObj->get('attendance_detail')->result_array();
        $arrFinalAbsent = array('timestamp');
        $i = 0;
        if (!empty($arrAbsent)) {
            $staff_detail = $this->coreObj->GetStaffName($arrAbsent[0]['entry_by']);
            foreach ($arrAbsent as $row) {
                $arrTempAbsent = array();
                $arrTempAbsent['timestamp'] = $row['timestamp'];
                $arrTempAbsent['type'] = 'ATTENDANCE';
                $arrTempAbsent['data'] = array('att_date' => $row['attendance_date'], 'reason' => $row['reason'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id']);
                $arrFinalAbsent[$i] = $arrTempAbsent;
                $i++;
            }
            return $arrFinalAbsent;
        } else {
            return 0;
        }
    }

    public function GetSummary($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $arrSummary = array();
        $this->load->model('parent/parent_core', 'coreObj');
        $term = $this->coreObj->GetTermDate();
        $month_names = array("April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March");
        $d1 = $term[0]['date_from'];
        $d2 = $term[1]['date_to'];
        $t1 = strtotime($d1);
        $t2 = strtotime($d2);

        $m1 = date("n", $t1);
        $mon = date("M", $t1);
        $y1 = date("Y", $t1);
        $m2 = date("n", $t2);
        $y2 = date("Y", $t2);
        $x = $m1;
        $y = $y1;
        $sumPresent = 0;
        $sumWorkingDays = 0;
        for ($i = 0; $i < count($month_names); $i++) {
            if ($x == 13) {
                $x = 1;
                $y = $y + 1;
            }
            $month = $x;
            $year = $y;
            $resultTWD = $this->TotalWorkingDays($month, $year);
            $resultPresent = $this->StudentPresentStatus($dataObj['adm_no'], $month, $year);
            $resultAbsent = $this->StudentAbsentStatus($dataObj['adm_no'], $month, $year);
            $arrFinal[] = array("total_working_days" => $resultTWD[0]['twd'], "total_present" => $resultPresent[0]['total_present'], "absent_summary" => $resultAbsent, "month" => $month_names[$i], "year" => $year);
//print_r($resultTWD[0]['twd']);exit();
            $x = $x + 1;
            $sumPresent = $sumPresent + $resultPresent[0]['total_present'];
            $sumWorkingDays = $sumWorkingDays + $resultTWD[0]['twd'];
//            print_r($resultTWD[0]['twd']);exit();
        }
        $percentAtt = round(($sumPresent * 100) / $sumWorkingDays);
        $arrTemp = array();
        $arrTemp['totPresent'] = $sumPresent;
//        print_r($arrTemp['totPresent']);exit();
        $arrTemp['totWrkdy'] = $sumWorkingDays;
        $arrTemp['percent'] = $percentAtt;
        $arrSummary['shortSummary'] = $arrTemp;
        $arrSummary['fullSummary'] = $arrFinal;
        return $arrSummary;
    }

    public function TotalWorkingDays($month, $year) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as twd');
        $dbObj->from('session_days');
        $dbObj->where('month(date)', $month);
        $dbObj->where('year(date)', $year);
        $dbObj->where('is_holiday', 'NO');
        $myTWD = $dbObj->get()->result_array();
        return $myTWD;
    }

    public function StudentPresentStatus($adm_no, $month, $year) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as total_present');
        $dbObj->from('attendance_detail');
        $dbObj->where('month(attendance_date)', $month);
        $dbObj->where('year(attendance_date)', $year);
        $dbObj->where('att_status', 'PRESENT');
        $dbObj->where('adm_no', $adm_no);
        $myPresentStatus = $dbObj->get()->result_array();
        return $myPresentStatus;
    }

    public function StudentAbsentStatus($adm_no, $month, $year) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('attendance_date,reason');
        $dbObj->from('attendance_detail');
        $dbObj->where('month(attendance_date)', $month);
        $dbObj->where('year(attendance_date)', $year);
        $dbObj->where('att_status', 'ABSENT');
        $dbObj->where('adm_no', $adm_no);
        $myAbsentStatus = $dbObj->get()->result_array();
        return $myAbsentStatus;
    }

}
