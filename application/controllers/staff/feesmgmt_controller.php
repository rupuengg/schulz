<?php

class feesmgmt_controller extends MY_Controller {

    public function index() {
        $this->load->view('staff/fees_mgmt/feesmgmt_view.php');
    }

    public function showClassRelation($class = NULL) {
        if ($class != NULL) {
            $this->load->model('staff/fees_model', 'modelObj');
            $class = $this->modelObj->GetStandardBySectionId($class);
        }
        $this->load->view('staff/fees_view/classrelation_view', array('selectedclass' => $class));
    }

    public function showData() {
        $this->load->model('staff/fees_model', 'objDetails');
        $standard = $this->objDetails->getIdStandard();
        $fees = $this->objDetails->getFeesName();
        try {
            echo json_encode(array("standardName" => $standard, "feesName" => $fees));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getFeesData() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->getFeesData($data);
        $categoryName = $this->objDetails->showUnselectFees($data);
        try {
            echo json_encode(array("feesdetail" => $result, "feesname" => $categoryName));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function saveDetails() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->saveFeesData($data);
        if ($result > 0) {
            echo printCustomMsg('SAVE', 'Setting save successfully', $result);
        } else {
            echo printCustomMsg('UPDATE', 'Update successfully.', -1);
        }
    }

    /**     * ******************************* Fees installment nitin ************************************************ */
    public function showFeesInstallment() {
        $this->load->model('staff/fees_model', 'objDetails');
        $installmentname = $this->objDetails->getInstallmentName();
        $this->load->view('staff/fees_view/feeinstallement_view', array("showname" => $installmentname));
    }

    public function getInstallment() {
        $data = json_decode($this->input->post('data'), TRUE);
        if ($data['billraisedate'] < $data['billenddate']) {
            $this->load->model('staff/fees_model', 'objDetails');
            $result = $this->objDetails->getAllInstallmentList($data);
            echo json_encode($result);
        } else {
            echo printCustomMsg('SAVERROR', 'please select no. greater than bill raise date', -1);
        }
    }

    public function saveInstlmntDetail() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->saveInstlmntData($data);
        if ($result > 0) {
            echo printCustomMsg('SAVE', 'Details save successfully', $result);
        } else {
            echo printCustomMsg('SAVEERROR', 'Oops something went wrong!!', -1);
        }
    }

    /*     * ******************************* student fee relation nitin ************************************************ */

    public function showStudentFeesProfile($admno) {
//        echo 'hi';exit;
        $this->load->model('staff/fees_model', 'modelObj');
        $result = $this->modelObj->getStudentDetails($admno);
        $this->load->view('staff/fees_view/studentfeesprofile_view', array("details" => $result));
    }

    public function customizeFees() {
        $classid = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->getStudentFeesStructure($classid);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function saveStudentData() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/fees_model', 'objDetails');
        $result = $this->objDetails->saveStudentData($data);
        if ($result > 0) {
            echo printCustomMsg('SAVE', 'Details save successfully', $result);
        } else {
            echo printCustomMsg('SAVEERROR', 'Oops something went wrong!!', -1);
        }
    }

    /*     * ********************************  head setting xcrud sapna ************************************************ */

    public function loadheadsettingview($catid = 'NA') {
        $this->load->view('staff/fees_view/headsetting_view', array('catid' => $catid));
    }

    public function fetchmainhead() {
        $this->load->model('staff/fees_model');
        $category = $this->fees_model->selectmainhead();
        try {
            echo json_encode($category);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
