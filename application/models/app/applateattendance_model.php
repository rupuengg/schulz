<?php

class applateattendance_model extends CI_Model {

    public function GetLateAttendance($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $term = $this->coreObj->GetTermDate($dbObj);
        $session_sdate = $term[0]['date_from'];
        $session_edate = $term[1]['date_to'];
        $dbObj->select('coming_date,reason,entry_by,timestamp');
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->where('adm_no', $dataObj['adm_no']);
        $dbObj->where('coming_date >=', $session_sdate);
        $dbObj->where('coming_date <=', $session_edate);
        $lateAttendanceResult = $dbObj->get('late_coming_details')->result_array();
        $arrFinalLateAtt = array();
        $i = 0;
        if (!empty($lateAttendanceResult)) {
            $staff_detail = $this->coreObj->GetStaffName($lateAttendanceResult[0]['entry_by'], $dbObj);
            foreach ($lateAttendanceResult as $row) {
                $arrLateAtt = array('timestamp' => $row['timestamp'], 'coming_date' => 'Came late on ' . $row['coming_date'], 'reason' => $row['reason'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id'], 'staff_pic' => $staff_detail['profilePic']);
                $arrFinalLateAtt[$i] = $arrLateAtt;
                $i++;
            }
            return $arrFinalLateAtt;
        }else{
            return 0;
        }
    }

    public function GetTardySummary($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $term = $this->coreObj->GetTermDate($dbObj);
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
        for ($i = 0; $i < count($month_names); $i++) {
            if ($x == 13) {
                $x = 1;
                $y = $y + 1;
            }
            $month = $x;
            $year = $y;
            $resultTardy = $this->StudentTardyStatus($dataObj['adm_no'], $month, $year, $dbObj);
            $tardyCount = count($resultTardy);
            $arrFinal[] = array("tardiness" => $tardyCount, "month" => $month_names[$i] . '-' . $year, "tardyDetail" => $resultTardy);

            $x = $x + 1;
        }
        return $arrFinal;
    }

    public function StudentTardyStatus($adm_no, $month, $year, $dbObj) {
        $dbObj->select('coming_date,reason');
        $dbObj->from('late_coming_details');
        $dbObj->where('month(coming_date)', $month);
        $dbObj->where('year(coming_date)', $year);
        $dbObj->where('adm_no', $adm_no);
        $dbObj->group_by('id');
        $myTardyStatus = $dbObj->get()->result_array();
        return $myTardyStatus;
    }

}
