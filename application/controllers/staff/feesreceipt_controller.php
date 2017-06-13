<?php

class feesreceipt_controller extends CI_Controller {

    public function showStudentFeeReceipt($Admno) {
        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->getStudentFeeReceipt($Admno);
        $this->load->view('staff/fees_view/studentfeereceipt_view', array("result" => $result));
    }

    public function showStudentFeeEntry() {

        $this->load->view('staff/fees_view/studentfeesentry_view');
    }

    public function selectedStudentDetails() {
        $adm_no = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/fees_model', 'objStdntDetails');
        $result = $this->objStdntDetails->getStdnFeesEntryDetail($adm_no);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function savePaymentDetails() {
        $paydetail = json_decode($this->input->post('data'), TRUE);

        $this->load->model('staff/fees_model', 'objPymntDetails');
        $saveDetails = $this->objPymntDetails->savePaymentDetails($paydetail);
        if ($saveDetails > 0) {
            echo printCustomMsg('SAVE', 'Payment details save successfully', $saveDetails);
        } else {
            echo printCustomMsg('SAVEERROR', 'Oops something went wrong!!', -1);
        }
    }

    public function viewInstlmntDetails() {
        $data = json_decode($this->input->post('data'), TRUE);

        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->viewInstlmntDetails($data);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function totalFineAmount() {
        $fineDays = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->totalFineAmount($fineDays);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function loadbanklistview() {

        $this->load->view('staff/fees_view/bank_view');
    }

    public function latefineview() {

        $this->load->view('staff/fees_view/latefine_view');
    }

}
