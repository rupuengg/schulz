<?php

class staffapplogin_controller extends CI_Controller {

    public function DeviceRegister() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('app/applogin_model', 'modelObj');
        $result = $this->modelObj->GetDeviceRegisterStatus($dataObj);
        echo $result;
    }

    public function LoginMe() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapplogin_model', 'modelObj');
            $stafffulldata = $this->modelObj->checkLoginDetail($dataObj);
            if (isset($stafffulldata['status'])) {
                $type = $stafffulldata['status'];
            } else {
                $type = $stafffulldata;
            }
            switch ($type) {
                case "TRUE":
                    echo printCustomMsg("TRUE", "Login Successfully", $stafffulldata);
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
                    echo printCustomMsg("FALSE", 'Error', null);
                    break;
            }
    }

}
