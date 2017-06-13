<?php

class activity_model extends CI_Model {

    public function empName() {

        $this->db->select('id,name,email_address,admin_type,email_status,sms_status,mobile_for_sms');
        $this->db->from('company_staff_details');
        $this->db->order_by("name", "asc");
        $emplist = $this->db->get()->result_array();
        return $emplist;
    }

    public function getEmpHour($from, $to, $staff_id) {
        $newfromdate = date('Y-m-d', strtotime($from));
        $newtodate = date('Y-m-d', strtotime($to));
        $this->db->select('sum(TIME_TO_SEC(hour_worked))/60 AS hour_worked');
        $this->db->from('acr_emp_activity_detail');
        $this->db->where('activity_date >=', $newfromdate);
        $this->db->where('activity_date <=', $newtodate);
        $this->db->where('staff_id', $staff_id);
        $totalhour = $this->db->get()->row_array();
        if (!empty($totalhour)) {
            return $totalhour;
        } else {
            return 0;
        }
    }

    public function totalHour() {
        $staff_id = $this->session->userdata('company_staff_id');
        $currentdate = date("Y-m-d");
        $this->db->select('sum(TIME_TO_SEC(hour_worked))/60 AS hour_worked');
        $hour = $this->db->get_where('acr_emp_activity_detail', array('activity_date' => $currentdate, 'staff_id' => $staff_id))->row_array();
        if ($hour['hour_worked'] != '') {
            return $hour;
        } else {
            return 0;
        }
    }

    public function GetEmpInformationOfActivity() {
        $prevdate = date('jS M,Y', strtotime($date . ' -1 day'));
        $todayDate = date('jS M,Y');
        $empList = $this->empName();
        for ($i = 0; $i < count($empList); $i++) {
            $todayStatus = $this->TodayActivityInfo($empList[$i]['id']);
            $previousStatus = $this->PrevdayActivityInfo($empList[$i]['id']);
            $message = '';
            switch ($empList[$i]['id']) {
                case (!empty($todayStatus) && !empty($previousStatus)):
                    "Dear " . $empList[$i]['name'] . ", <p>You have succesfully punched your daily activity report today. Excellent, Good work.</p>";
                    break;
                case(!empty($todayStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ", <p>You have missed punching your activity report for yesterday (" . $prevdate . ").. Please fill it by EOD.</p>";
                    $empList[$i]['status'] = 'PREVIOUS';
                    break;
                case (!empty($previousStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ",<p>You have missed punching your activity report today (" . $todayDate . "). Please fill it by EOD.</p>";
                    $empList[$i]['status'] = 'TODAY';
                    break;
                case (empty($todayStatus) && empty($previousStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ",<p>You have missed punching your activity report in last two days. Kindly please punch it at top most priority.</p>";
                    $empList[$i]['status'] = 'BOTH';
                    break;
            }
            $empList[$i]['message'] = $message;
            $empList[$i]['subject'] = "Daily activity report status-" . $todayDate;
            $empList[$i]['serviceType'] = 'NIGHT';
        }
        return $empList;
    }

    public function TodayActivityInfo($empId) {
        $todayDate = date('Y-m-d');
        $EmpRecord = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $empId, 'activity_date' => $todayDate))->result_array();
        return $EmpRecord;
    }

    public function PrevdayActivityInfo($empId) {
        $prevdate = date('Y-m-d', strtotime($date . ' -1 day'));
        $EmpRecord = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $empId, 'activity_date' => $prevdate))->result_array();
        return $EmpRecord;
    }

    public function ReminderForReport() {
        $empList = $this->empName();
        for ($i = 0; $i < count($empList); $i++) {
            $previousStatus = $this->PrevdayActivityInfo($empList[$i]['id']);
            switch ($empList[$i]['id']) {
                case (empty($previousStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ",<p> Genral Reminder, you have not punched your daily activity report for yesterday. Please punch it now.</p>";
                    break;
            }
            $empList[$i]['message'] = $message;
            $empList[$i]['subject'] = 'Reminder: Punch your daily activity report ';
            $empList[$i]['serviceType'] = 'MORNING';
        }
        return $empList;
    }

    public function NightMessageDeatils() {
        include(APPPATH . 'config/database' . EXT);
        $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
        $systemDBObj = $this->load->database($webUserDsn, TRUE);
        $empList = $this->GetEmpInformationOfActivity();
        foreach ($empList as $row) {
            if ($row['mobile_for_sms'] != '' && $row['mobile_for_sms'] != 0) {
                $msgTempArr[] = $row['message'];
                $msgTempArr[] = $row['mobile_for_sms'];
            }
        }
        $strmobileno = implode("`", $msgTempArr);
        $this->load->model('core/sms_api', 'smsApiObj');
        $smsReasult = $this->smsApiObj->sendsms('GLOBEL', 'MmsgMno', $strmobileno, $systemDBObj);
        if ($smsReasult == 'TRUE') {
            return 'TRUE';
        } else {
            return 'FALSE';
        }
    }

    public function MorningMessageDeatils() {
        include(APPPATH . 'config/database' . EXT);
        $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
        $systemDBObj = $this->load->database($webUserDsn, TRUE);
        $empList = $this->ReminderForReport();
        foreach ($empList as $row) {
            if ($row['mobile_for_sms'] != '' && $row['mobile_for_sms'] != 0) {
                $msgTempArr[] = $row['message'];
                $msgTempArr[] = $row['mobile_for_sms'];
            }
        }
        $strmobileno = implode("`", $msgTempArr);
        $this->load->model('core/sms_api', 'smsApiObj');
        $smsReasult = $this->smsApiObj->sendsms('GLOBEL', 'MmsgMno', $strmobileno, $systemDBObj);
        if ($smsReasult == 'TRUE') {
            return 'TRUE';
        } else {
            return 'FALSE';
        }
    }

}
