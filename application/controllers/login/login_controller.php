<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_controller extends CI_Controller {

    public function index() {
        if (!$this->session->userdata('logintype')) {
            $this->load->view('login/login');
        } else {

            switch ($this->session->userdata('logintype')) {
                case "STAFF":
                    switch ($this->session->userdata('staff_desig')) {
                        case "ADMIN":
                            redirect(str_replace("index.php/", "", 'staff/admindashboard'));
                            break;
                        case "FACULTY":
                            redirect(str_replace("index.php/", "", 'staff/staffdashboard'));
                            break;
                        case "LIBRARIAN":
                            redirect(str_replace("index.php/", "", 'staff/issuebooks'));
                             break;
                        case "ACCOUNT":
                            redirect(str_replace("index.php/", "", 'staff/studentfeesentry'));
                             break;
                        case "DEO":
                            redirect(str_replace("index.php/", "", 'staff/deo'));
                             break;
                        default :
                            echo 'PROBLEM IN LOGIN TYPE. Please contact to admin.';
                            exit();
                    }
                    break;
                case "PARENT":
                    redirect(str_replace("index.php/", "", 'parent/homepage'));
                    break;

                case "COMPANY":
                    redirect(str_replace("index.php/", "", 'testing/company'));
                    break;
                default :
                    $this->session->sess_destroy();
                    redirect("/");
            }
        }
    }

    public function checkLoginDetail() {
        $this->load->model('login/login_model', "loginModel");
		$data = array("username" => "demoadmin" ,"password" => "demo123");
        // $result = $this->loginModel->checkLoginDetail(json_decode($this->input->post('data'), true), 'USER', '-1');
        $result = $this->loginModel->checkLoginDetail($data, 'USER', '-1');

        switch ($result) {
            case "TRUE":
                echo printCustomMsg("TRUE", "Login Successfully", null);
                break;
            case "COMPANY":
                echo printCustomMsg("COMPANY", "Login Successfully", null);
                break;
            case "MISMATCH":
                echo printCustomMsg("FALSE", "Login ID and Password Mismatch", null);
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
                echo printCustomMsg("FALSE", "UNKNOWN ERROR", null);
                break;
            case "DBNOTFOUND":
                echo printCustomMsg("DBNOTFOUND", "Problem in School Database configuration. Please contact to school admin", null);
                break;
            default :
                echo printCustomMsg("FALSE", $result, null);
                break;
        }
    }

    public function resetpassword() {
        if ($this->session->userdata('logintype')) {
            $this->load->view('login/changepassword');
        } else {
            $this->session->sess_destroy();
            redirect("/");
        }
    }

    public function CheckResetPassword() {
        $this->load->model('login/login_model', "loginModel");
        $result = $this->loginModel->resetPassword(json_decode($this->input->post('data'), true));
        switch ($result) {
            case "TRUE":
                echo printCustomMsg("TRUE", "Password Changed Successfully", null);
                break;
            case "FALSE":
                echo printCustomMsg("FALSE", "Wrong Old Password", null);
                break;
            case "WRONG":
                echo printCustomMsg("WRONG", "Something Went Wrong, Password Not Changed", null);
                break;
            default :
                echo printCustomMsg("FALSE", $result, null);
                break;
        }
    }

    public function changeidalso() {
        $this->load->model('login/login_model', 'checklogin');
        $result = $this->checklogin->checkLogin($this->session->userdata('user_id'), true);
        $this->load->view('login/change_loginid_password', array("login" => $result));
    }

    public function changeidpassword() {
        $this->load->model('login/login_model', 'changeidpassword');
        $result = $this->changeidpassword->changeidpassword($this->input->post('data'), true);
        switch ($result) {
            case "WRONG_OLD_ID_PASSWORD":
                echo printCustomMsg($result, "Your current login id password is not correct. Please re-enete it and proceed.", null);
                break;
            case "USER_NAME_NOT_AVAILABLE":
                echo printCustomMsg($result, "This username is not available. Please select the other username", null);
                break;
            case "DB_ENTRY_WRONG":
                echo printCustomMsg($result, "Problem in saving data", null);
                break;
            case "TRUE":
                echo printCustomMsg($result, "Password Succesfully Changed, Please login again with your new username and password", null);
                break;
            case "NEW_PASSWORD_MISMATCH":
                echo printCustomMsg($result, "New Password Mistach", null);
                break;
            default :
                echo printCustomMsg('NA', "Something went wrong", null);
                break;
        }
        exit();
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect("/");
    }

    public function accountdeactivate() {
        $this->load->view('login/accountdeactivated');
    }

    private function getFirstController($staffMenu) {
        foreach ($staffMenu as $value) {
            foreach ($value['childDetail'] as $value) {
                if ($value['selected']) {
                    return $value['page_url'];
                }
            }
        }
    }

    public function CheckStatus() {
        if (!$this->session->userdata('logintype')) {
            echo 'TIMEOUT';
        } else {
            echo 'is_login';
        }
    }

}
