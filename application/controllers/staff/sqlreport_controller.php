<?php

class sqlreport_controller extends MY_Controller {

    public function index() {
        $this->load->view('staff/sqlreport_view/sqlreport_view');
    }

    public function GetSearchField() {
        $this->load->model('staff/sqlreport_model', 'modelObj');
        $field = $this->modelObj->GetSearchField();
        try {
            echo json_encode($field);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SearchReport() {
        $dataobj = $this->input->post('data');
        $this->load->model('staff/sqlreport_model', 'modelObj');
        $result = $this->modelObj->GetSearchResult($dataobj);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SqlReportResult() {
        $this->load->view('staff/sqlreport_view/sqlresult_view');
    }

}
