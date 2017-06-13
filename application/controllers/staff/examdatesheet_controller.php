<?php

class examdatesheet_controller extends MY_Controller {

    public function Index() {

        $this->load->view('staff/marks_view/datesheet_view.php');
    }

    public function Sectionlist() {
        $this->load->model('staff/examdatesheet_model', 'modelObj');
        $result = $this->modelObj->loadStandars();
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function sectiondata() {
        $class = json_decode($this->input->post('data'), true);
        $this->load->model('staff/examdatesheet_model', 'modelObj');
        $result = $this->modelObj->loadSection($class['class']);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function savealldata() {
        $alldata = json_decode($this->input->post('data'), true);
        $this->load->model('staff/examdatesheet_model', 'modelObj');
        $result = $this->modelObj->dateSheet($alldata);
        if ($result > 0) {
            echo printCustomMsg("TRUE", "Datesheet Save Successfully", $result);
        } else {
            echo printCustomMsg("ERRINPUT", "Some error occurred, Please try again!", $result);
        }
    }

}
