<?php

class applogin_controller extends CI_Controller {

    public function GetSchoolList() {
        $this->load->model('app/applogin_model', 'modelObj');
        $schoolList = $this->modelObj->GetAllSchoolList();
        echo json_encode(array('schoolNameList' => $schoolList));
    }

    public function DeviceRegister() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('app/applogin_model', 'modelObj');
        $result = $this->modelObj->GetDeviceRegisterStatus($dataObj);
        echo $result;
    }

    public function LoginMe() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        //$dataObj = json_decode('{"school_code":"TESTDB1","password":"abc123","device_id":"862297024351669","username":"demostudent1"}', TRUE);
        $this->load->model('app/applogin_model', 'modelObj');
        $deviceStatus=$this->checkDeviceStatus($dataObj['device_id']);
        $parentusefulldata = $this->modelObj->checkLoginDetail($dataObj);
        if (isset($parentusefulldata['status'])) {
            $type = $parentusefulldata['status'];
        } else {
            $type = $parentusefulldata;
        }
        switch ($type) {
            case "TRUE":
                echo printCustomMsg("TRUE", "Login Successfully", $parentusefulldata);
                break;
            case "DEOLOGIN":
                echo printCustomMsg("DEOLOGIN", "You are login as deo, So you won't be able to login in this application.", null);
                break;
            case "COMPANY":
                echo printCustomMsg("COMPANY", "Login Successfully", null);
                break;
            case "MISMATCH":
                echo printCustomMsg("FALSE", "Login ID and password mismatch", null);
                break;
            case "FIRSTTIMELOGIN":
                echo printCustomMsg("FIRSTTIMELOGIN", "It seems you have login here first time. You must change you Login Id and passowrd.", null);
                break;
            case "DEACTIVATED":
                echo printCustomMsg("DEACTIVATED", "Your Account has been deactivated. Please contact to admin for further detail.", null);
                break;
            case "RESET":
                echo printCustomMsg("RESET", "Your Account password is reset by School Admin. You must change your passowrd and proceed.", null);
                break;
            case "FALSE":
                echo printCustomMsg("FALSE", "Device not register please contact to School Admin.", null);
                break;
            case "DBNOTFOUND":
                echo printCustomMsg("DBNOTFOUND", "Problem in School Database configuration. Please contact to school admin", null);
                break;
            default :
                echo printCustomMsg("FALSE", $result, null);
                break;
        }
//       s echo json_encode($parentusefulldata);
    }

    public function SchoolDetail() {
        $this->load->model('app/applogin_model', 'modelObj');
        $schoolBrandUrl = $this->modelObj->GetSchoolBrandUrl(json_decode($this->input->post('data'), TRUE));
        echo json_encode($schoolBrandUrl);
    }

    public function getStaffPhoto($id, $type = "THUMB") {
        if ($id) {
            $this->load->model('app/applogin_model', 'modelObj');
            $staffDatabase = $this->modelObj->GetStaffDatabaseName($id);
            $photoPath = $this->modelObj->getStaffPhoto($id, $type, $staffDatabase);
            if (!file_exists($photoPath)) {
                $photoPath = DPHOTOPATH;
                $this->output
                        ->set_content_type(@end(explode(".", $photoPath))) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
                        ->set_output(file_get_contents($photoPath));
            } else {

                $this->output
                        ->set_content_type(@end(explode(".", $photoPath))) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
                        ->set_output(file_get_contents($photoPath));
            }
        }
    }

    public function GetStudentPhoto($adm_no, $type = "THUMB") {
        if ($adm_no) {
            $this->load->model('app/applogin_model', 'modelObj');
            $studentDb = $this->modelObj->GetStudentDatabaseName($adm_no);


            $photoPath = $this->modelObj->getStudentPhoto($adm_no, $type, $studentDb);

            if (!file_exists($photoPath)) {
                $photoPath = DPHOTOPATH;
                $this->output
                        ->set_content_type(@end(explode(".", $photoPath))) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
                        ->set_output(file_get_contents($photoPath));
            } else {
                $this->output
                        ->set_content_type(@end(explode(".", $photoPath))) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
                        ->set_output(file_get_contents($photoPath));
            }
        }
    }

    public function checkDeviceStatus($deviceId) {
        $url = "http://www.meraschoolportal.com/school/index.php/app/checkdevicestatus/" . $deviceId;
//        $dataObj = curl_browse($url);
        $dataObj = json_decode(curl_browse($url), true);
        unset($dataObj['value']['id']);
        $this->load->model('app/applogin_model', 'modelObj');
        $result = $this->modelObj->GetDeviceRegisterStatus($dataObj['value']);
        return true;
    }

}
