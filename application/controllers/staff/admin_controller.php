<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin_controller extends MY_Controller {

    public function loadAdminDashboard($section_id = 'ALL') {
        $this->load->model('staff/admin_model', 'objAdminDetails');
        $schoolcode = $this->session->userdata('school_code');
        $holidaylist = $this->objAdminDetails->getHoliday();
        $todaylate = $this->objAdminDetails->getTodayLateAttendance();
        $todayabsent = $this->objAdminDetails->getTodayAbsentAttendance();
        $todayabsentStaff = $this->objAdminDetails->getTodayStaffAbsentAttendance();
        $graphData = $this->objAdminDetails->getLoginGraphData($schoolcode);
        $this->load->model('staff/staff_model', 'objBirthday');
        $examDateSheet = $this->objAdminDetails->GetExamDatesheet();
        $birthday = $this->objBirthday->getBirthday();
        $this->load->view('staff/admin_view/admindashboard_view', array("holiday" => $holidaylist, "birthday" => $birthday, "late" => $todaylate, "absent" => $todayabsent, "staffabsent" => $todayabsentStaff, "loginGraph" => $graphData, "examDatesheet" => $examDateSheet));
    }

    public function loadAdminDetails() {
        $schoolcode = $this->input->post('data');
        $this->load->model('staff/staff_model', 'objBirthday');
        $birthday = $this->objBirthday->getBirthday();
        $this->load->model('staff/admin_model', 'objAdmindashboard');
        $bluecard = $this->objAdmindashboard->getBlueCard();
        $todaybluecard = $this->objAdmindashboard->getTodayBlueCard();
        $yellowcard = $this->objAdmindashboard->getYellowCard();
        $pinkcard = $this->objAdmindashboard->getPinkCard();
        $redcard = $this->objAdmindashboard->getRedCard();
        $todayyellowcard = $this->objAdmindashboard->getTodayYellowCard();
        $todaypinkcard = $this->objAdmindashboard->getTodayPinkCard();
        $todayredcard = $this->objAdmindashboard->getTodayRedCard();
        $todayabsent = $this->objAdmindashboard->getTodayAbsentAttendance();
        $todaypresent = $this->objAdmindashboard->getTodayPresentAttendance();
        $todaylate = $this->objAdmindashboard->getTodayLateAttendance();
        $todayabsentStaff = $this->objAdmindashboard->getTodayStaffAbsentAttendance();
        $section = $this->objAdmindashboard->getSectionAttendance();
        $student = $this->objAdmindashboard->getStudentloginStatus($schoolcode);
        $staff = $this->objAdmindashboard->getStaffloginStatus($schoolcode);
        $holidaylist = $this->objAdmindashboard->getHoliday();
        $todayholiday = $this->objAdmindashboard->getTodayisholiday();
        $last7daystffntlogged = $this->objAdmindashboard->getlast7daystffNotlogged($schoolcode);
        $output = array();
        $output['birthday'] = $birthday;
        $output['blue'] = $bluecard;
        $output['totalblue'] = $todaybluecard;
        $output['yellow'] = $yellowcard;
        $output['pink'] = $pinkcard;
        $output['red'] = $redcard;
        $output['totalyellow'] = $todayyellowcard;
        $output['totalpink'] = $todaypinkcard;
        $output['totalred'] = $todayredcard;
        $output['absent'] = $todayabsent;
        $output['present'] = $todaypresent;
        $output['late'] = $todaylate;
        $output['absentstaff'] = $todayabsentStaff;
        $output['section'] = $section;
        $output['student'] = $student;
        $output['staff'] = $staff;
        $output['holiday'] = $holidaylist;
        $output['todayholiday'] = $todayholiday;
        $output['notlogged'] = $last7daystffntlogged;
        echo json_encode($output);
    }

    public function loadTodayholiday() {
        $this->load->model('staff/admin_model', 'objAdmindashboard');
        $todayholiday = $this->objAdmindashboard->getTodayisholiday();
        $output = array();
        $output['todayholiday'] = $todayholiday;


        echo json_encode($output);
    }

    public function updateHolidy() {
        $this->load->model('staff/holiday_model', 'objholiday');
        $reason = $this->input->post('data');
        $dated = $this->input->post('date');
        $is_holiday = $this->input->post('holiday');
        if ($is_holiday == 'Yes') {
            $holidaytype = 'No';
        } else {
            $holidaytype = 'Yes';
        }
        $holiday = $this->objholiday->MarkSingleDayOpenOrClose($dated, $reason, $holidaytype);
        if ($holiday) {
            echo printCustomMsg("TRUE", "Holiday Succesfully Updated", $holiday);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        };
    }

    public function GetExamDateSchedule() {
        $examId = $this->input->post('data');
        $this->load->model('staff/admin_model', 'modelObj');
        $examDatesheet = $this->modelObj->GetMyExamDateSchedule($examId);
        try {
            echo json_encode($examDatesheet);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR',NULL,$exe->getMessage());
        }
    }

}
