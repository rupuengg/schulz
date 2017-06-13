<?php

class holiday_controller extends MY_Controller {

    public function holidayDetail() {

        $this->load->view('staff/holiday/holidaydetail');
    }

    public function holidayTerm() {

        $this->load->view('staff/holiday/holidaysession');
    }

    public function saveTermSession() {

        $myArr = json_decode($this->input->post('data'), true);
//        print_r($myArr);exit;
        $this->load->model('staff/holiday_model', 'modelObj');
        $result = $this->modelObj->saveTermSession($myArr);
        if ($result == true) {
            echo printCustomMsg("TRUESAVE", null, $result);
        } else if ($result == 'INVALID') {
            echo printCustomMsg("ERR", "Please fill all the details", -1);
        } else {
            echo printCustomMsg("TRUESAVEERR");
        }
    }

    public function DecLargeHoliday() {

        $dataArr = json_decode($this->input->post('data'), true);
        $this->load->model('staff/holiday_model', 'modelObj');
        $result = $this->modelObj->DecLargeHolidayModel($dataArr);
        if ($result == true) {
            echo printCustomMsg("TRUESAVE", null, $result);
        } else {
            echo printCustomMsg("TRUESAVEERR");
        }
    }

    public function getHolidaytermDetail() {
        $this->load->model('staff/holiday_model', 'modelObj');
        $res = $this->modelObj->getHolidaytermDetail();
        try {
            echo json_encode(array("holidayterm" => $res));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
