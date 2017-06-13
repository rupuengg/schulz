<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class attendence_controller extends CI_Controller {

    public function index() {
        $resultSection = array();
        if ($this->session->userdata('logintype') == 'ADMIN') {
            $this->load->model('core/core', 'modelObj');
            $resultSection = $this->modelObj->GetAllSection();
        }
        $this->load->view('staff/attendence/attendence_view.php', array("sections" => $resultSection));
    }

    public function GetAttendence() {
        $date = $this->input->post('date');
        $date = changedateformate($date);
        if ($this->session->userdata('staff_desig') == 'FACULTY' && $date < date("Y-m-d")) {
            echo printCustomMsg("ERRINPUT", "You can not mark attendence of past days.", "-1");
            exit();
        }
        if ($date <= date("Y-m-d")) {
            if ($this->session->userdata('staff_desig') == 'FACULTY' || $this->session->userdata('staff_desig') == 'DEO') {
                if ($this->session->userdata('is_staff_classteacher') == 'YES') {
                    $section_id = $this->session->userdata('staff_classteacher_section_id');
                } else {
                    echo printCustomMsg("ERRINPUT", "You are not a faculty.", "-1");
                    exit();
                }
            } else {
                if ($this->session->userdata('staff_desig') == 'ADMIN') {
                    $section_id = $this->input->post('section_id');
                }
            }
            $this->load->model('core/core', 'modelObj');
            $result1 = $this->modelObj->getAllStudent($section_id);
            $this->load->model('staff/attendence_model', 'attendence_model');
            $result = $this->attendence_model->GetAttendence($section_id, $result1, $date);
            if ($result == 'HOLIDAY') {
                echo printCustomMsg("ERRINPUT", "You can not mark today's attendance.Because today is holiday.", "-1");
            } else if ($result == 'NOTCLASSTEACHER') {
                echo printCustomMsg("ERRINPUT", "You can not mark attendence.Because You are not a classteacher", "-1");
            } else {
                echo printCustomMsg("TRUE", "data Loaded Successfully", $result);
            }
        } else {
            echo printCustomMsg("ERRINPUT", "Please select valid date . must less than or equal to today date.", "-1");
        }
    }

    public function SaveAttendenceDetail() {
        $date = changedateformate($this->input->post('date'));
        if ($this->session->userdata('staff_desig') == 'FACULTY' || $this->session->userdata('staff_desig') == 'DEO') {
            if ($this->session->userdata('is_staff_classteacher') == 'YES') {
                $section_id = $this->session->userdata('staff_classteacher_section_id');
            } else {
                echo printCustomMsg("ERRINPUT", "You are not a faculty.", "-1");
                exit();
            }
        } else {
            if ($this->session->userdata('staff_desig') == 'ADMIN') {
                $section_id = $this->input->post('section_id');
            }
        }
        $this->load->model('staff/attendence_model', 'modelObj');
        if ($this->session->userdata('staff_desig') == 'FACULTY' && $this->modelObj->checkAttendanceStatus($section_id) == true) {
            echo printCustomMsg("ERRINPUT", "You already marked today's attendance.you can't mark again.", "-1");
            exit();
        }
        if ($date <= date("Y-m-d")) {
            $myArr = json_decode($this->input->post('data'), true);
            $result = $this->modelObj->SaveAttendenceDetail($myArr, $date, $section_id);
            if ($result == -1) {
                echo printCustomMsg("TRUESAVEERR");
            } else {
                echo printCustomMsg("TRUESAVE", null, $result);
            }
        } else {
            echo printCustomMsg("ERRINPUT", "Please select valid date . must less than or equal to today date", "-1");
        }
    }

    public function MarkAllAttendenceDetail() {
        $date = changedateformate($this->input->post('date'));
        if ($this->session->userdata('staff_desig') == 'FACULTY') {
            if ($this->session->userdata('is_staff_classteacher') == 'YES') {
                $section_id = $this->session->userdata('staff_classteacher_section_id');
            }
        } else {
            $section_id = $this->input->post('section_id');
        }
        if ($date <= date("Y-m-d")) {
            $myArr = json_decode($this->input->post('data'), true);
            $this->load->model('staff/attendence_model', 'modelObj');
            $result = $this->modelObj->MarkAllAttendenceDetail($myArr, $date, $section_id);
            if ($result == -1) {
                echo printCustomMsg("TRUESAVEERR");
            } else {
                echo printCustomMsg("TRUESAVE", null, $result);
            }
        } else {
            echo printCustomMsg("ERRINPUT", "Please select valid date . must less than or equal to today date", "-1");
        }
    }

    // Attendence summary Controller

    public function AttendenceSummaryView() {

        $this->load->view('staff/attendence/attsummary_view.php');
    }

    public function GetSummary() {
        $date = changedateformate($this->input->post('date'));
        $this->load->model('staff/attendence_model', 'att_summary_model');
        if ($date <= date("Y-m-d")) {
            $this->load->model('core/core', 'modelSummaryObj');
            if ($this->session->userdata('staff_desig') == 'FACULTY') {
                if ($this->session->userdata('is_staff_classteacher') == 'YES') {
                    $result2[] = array('id' => $this->session->userdata('staff_classteacher_section_id'), 'standard' => $this->session->userdata('staff_classteacher_class'));
                } else {
                    echo printCustomMsg("CLSTCHERR", "You can not see attendence summary.Because You are not a class teacher..", -1);
                }
            } else {
                if ($this->session->userdata('staff_desig') == 'ADMIN') {
                    $result2 = $this->modelSummaryObj->getAllSection();
                } else {
                    echo printCustomMsg("USERERR", "You can not see attendence summary.Because You are not a admin..", -1);
                }
            }
            $myArr = json_decode($this->input->post('data'), true);
            $holidayStatus = $this->att_summary_model->CheckHoliday($date);

            if ($holidayStatus) {
                echo printCustomMsg('HOLIDAY', 'School close on ' . date('d-m-Y', strtotime($date)), -1);
            } else {
                $result3 = $this->att_summary_model->GetSummary($result2, $date);
                echo printCustomMsg("TRUE", "data Loaded Successfully", json_encode($result3));
            }
        } else {
            echo printCustomMsg("ERRINPUT", "Please select valid date . must less than or equal to today date", "-1");
        }
    }

    /*     * **************************************Late Entry Module By Kartik************************************************************** */

    public function LateAttendance() {
        $this->load->view('staff/attendence/late_attendance');
    }

    public function searchStudent() {
        $studentName = $this->input->get('search');
        $this->load->model('staff/attendence_model', 'modelObj');
        $searchData = $this->modelObj->studentname($studentName);
        try {
            echo json_encode(array("results" => $searchData));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function savelatedata() {
        $myArr = json_decode($this->input->post('data'), true);
        for ($i = 0; $i < count($myArr['alldata']); $i++) {
//            print_r($myArr['alldata'][$i]['adm_no']);exit;
            $newdate = date('Y-m-d', strtotime($myArr['alldata'][$i]['coming_date']));
            $insertArr[] = array('adm_no' => $myArr['alldata'][$i]['adm_no'], 'coming_date' => $newdate, 'coming_time' => $myArr['alldata'][$i]['coming_time'], 'reason' => $myArr['alldata'][$i]['reason'], 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        }
        $this->load->model('staff/attendence_model', 'modelObj');
        $result = $this->modelObj->savelatedata($insertArr);
        if ($result > 0) {
            echo printCustomMsg("TRUE", "Data Saved Successfully", $result);
        } else {
            echo printCustomMsg("ERRINPUT", "Please Fill Data Correctly", $result);
        }
    }

}
