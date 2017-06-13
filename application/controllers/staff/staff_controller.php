<?php

class staff_controller extends CI_Controller {

    public function index() {
        $this->load->view('staff/staff_view/index');
    }

    public function getStaffDetail($id = "ALL") {
        $this->load->model('staff/staff_model', 'modelObj');
        $result = $this->modelObj->getStaffDetail($id);
        $this->load->model('core/core', 'codeModelObj');
        $departMentList = $this->modelObj->getAllDepartment();
        $designationList = $this->modelObj->getAllDesignation();
        try {
            echo json_encode(array("department" => $departMentList, "stafflist" => $result, "designation" => $designationList));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getStaffPhoto($id, $type = "THUMB") {
        if ($id) {
            $this->load->model('staff/staff_model', 'modelObj');
            $photoPath = $this->modelObj->getStaffPhoto($id, $type);
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

    public function saveUpdateStaffDetail() {                           //New change made by aman
        $myArr = json_decode($this->input->post('data'), true);
        $randomnum = json_decode($this->input->post('random'), true);
        $this->load->model('staff/staff_model', 'modelObj');
        $result = $this->modelObj->saveUpdateStaffDetail($myArr, $randomnum);
        try {
            if ($result == -1) {
                echo printCustomMsg("TRUESAVEERR");
            } else if ($result == 'DOJ') {
                echo printCustomMsg('DOJERROE', 'Please submit correct date of joining,then try again..', -1);
            } else if ($result == 'DOB') {
                echo printCustomMsg('DOBERROE', 'Please submit correct date of birth,then try again..', -1);
            } else {
                if (isset($myArr['id']) && $myArr['id'] != '') {
                    echo printCustomMsg("UPDATE", "Staff details updated successfully.", $result);
                } else {
                    echo printCustomMsg("SAVE", "Staff details saved successfully..", $result);
                }
            }
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function saveStaffPrivilege() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('staff/staff_model', 'modelObj');
        $result = $this->modelObj->saveStaffPrivilege($myArr);
        try {
            if ($result) {
                echo printCustomMsg("TRUE", "Staff Privilege Saved Successfully", -1);
            } else {
                echo printCustomMsg("ERR", "Please select atleast single Privilege then try to save.", -1);
            }
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getStaffMenu($id = NULL) {

        $this->load->model('staff/staff_model', 'modelObj');
        $db = $this->session->userdata('database');
        $dbObj = $this->load->database($db, TRUE);
        $result = $this->modelObj->getMenu($id, $dbObj);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    /*     * ***************************staff Dashboard details start***************************** */

    public function loadStaffDashboard() {
        $staff_id = $this->session->userdata('staff_id');
        $this->load->model('staff/admin_model', 'objAdminDetails');
        $this->load->model('staff/staff_model', 'objStaffDashboarddetail');
        $birthday = $this->objStaffDashboarddetail->getBirthday();
        $subject = $this->objStaffDashboarddetail->getTodaysClass($staff_id);
        $event = $this->objStaffDashboarddetail->getEventList($staff_id);
        $notice = $this->objStaffDashboarddetail->getNoticeList($staff_id);
        $card = $this->objStaffDashboarddetail->getCardDetails($staff_id);
        $examDateSheet = $this->objAdminDetails->GetExamDatesheet();
        $todolist = $this->objStaffDashboarddetail->getTodoList();
        $homework = $this->objStaffDashboarddetail->GetHomeworkdetail($staff_id);
        try {
            $this->load->view('staff/staff_view/staffdashboard_view', array("todoList" => $todolist, "homeworkList" => $homework, "birthday" => $birthday, "subject" => $subject, "event" => $event, "notice" => $notice, "card" => $card, "examDatesheet" => $examDateSheet));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function loadCardDetails() {
        $staffid = $this->input->post('data');
        $this->load->model('staff/staff_model', 'objStaffdetail');
        $card = $this->objStaffdetail->getCardDetails($staffid);
        $output = array();
        $output['card'] = $card;
        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function do_upload() {
        $imageName = $this->input->post('data');
        $this->db->select('start_year,end_year');
        $schoolSession = $this->db->get_where('school_db_year_wise', array('current_db' => 'YES', 'school_code' => $this->session->userdata('school_code')))->row_array();
        $currentsession = $schoolSession['start_year'] . '_' . $schoolSession['end_year'];
        $pathToUpload = 'files/' . $this->session->userdata('school_code') . '/' . $currentsession . '/';
        if (!is_dir($pathToUpload)) {
            mkdir($pathToUpload, 0777, TRUE);
        }

        $config = array(
            'upload_path' => $pathToUpload,
            'allowed_types' => "gif|jpg|png|jpeg",
            'overwrite' => TRUE,
            'max_size' => "4048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1248",
            'max_width' => "3026"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('userfile')) {
            $data = array('upload_data' => $this->upload->data());
            $this->load->model('staff/staff_model', 'modelObj');
            $this->modelObj->UpadteProfilePic($pathToUpload . $data['upload_data']['file_name']);
            $this->loadStaffDashboard();
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->loadStaffDashboard($error);
        }
    }

    public function loadStaffDetails() {
        $staffid = $this->input->post('data');
        $this->load->model('staff/staff_model', 'objStaffdetail');
        $profile = $this->objStaffdetail->getStaffDetail($staffid);
        $card = $this->objStaffdetail->getCardDetails($staffid);
        $this->load->model('core/core', 'objStudentList');
        $output = array();
        $output['profile'] = $profile;
//        $output['studentlist'] = $studentlist;
        $output['card'] = $card;

        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function LoadTodoView() {
        $this->load->view('staff/staff_view/viewalltodo');
    }

    public function SaveNewTodoData() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/staff_model', 'objTodo');
        $todo = $this->objTodo->savetododata($dataObj);
        if ($todo) {
            echo printCustomMsg("TRUE", "Todo Succesfully Saved", $todo);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        };
    }

    public function deleteTodoData() {
        $this->load->model('staff/staff_model', 'objDeleTodo');
        $deltodo = $this->objDeleTodo->deletetododata();
        if ($deltodo) {
            echo printCustomMsg("TRUE", "Todo Succesfully Deleted", $deltodo);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        };
    }

    public function deleteCardData() {
        $this->load->model('staff/staff_model', 'objDeleCards');
        $delCard = $this->objDeleCards->deleteCards();
        if ($delCard) {
            echo printCustomMsg("TRUE", "Card Succesfully Deleted", $delCard);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        };
    }

    public function loadCards() {
        $this->load->model('staff/staff_model', 'objIssueCards');
        $cards = $this->objIssueCards->issuecardDetails();
        if ($cards) {
            echo printCustomMsg("TRUE", "Cards Succesfully Issued", $cards);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        };
    }

    public function getAllTodoList() {
        $this->load->model('staff/staff_model', 'ModelObj');
        $todolist = $this->ModelObj->getTodoList();
        try {
            echo json_encode($todolist);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function viewAllTodoList() {
        $this->load->model('staff/staff_model', 'ModelObj');
        $todolist = $this->ModelObj->viewTodoList();
        try {
            echo json_encode($todolist);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function todocomplete() {
        $this->load->model('staff/staff_model', 'ModelObj');
        $todocomplet = $this->ModelObj->todocomplete();
        if ($todocomplet) {
            echo printCustomMsg("TRUE", "Todo Successfully Completed", $todocomplet);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        };
    }

    /*     * ***************************staff profile details start***************************** */

    public function loadStaffView($staff_id = NULL) {
        $staff_id = str_replace('%20', '', $staff_id);
        $this->load->view("staff/staff_view/staffprofile_view", array("staff_id" => $staff_id));
    }

    public function loadStaffprofile() {
        $staffid = $this->input->post('data', TRUE);
        $this->load->model('staff/staff_model', 'objStaffdetails');
        $profile = $this->objStaffdetails->getStaffDetail($staffid);
        $Depart = $this->objStaffdetails->getStaffDesignation($staffid);
        $event = $this->objStaffdetails->geteventIncharge($staffid);
        $eventvolunteer = $this->objStaffdetails->geteventVolunteer($staffid);
        $Cards = $this->objStaffdetails->getCardDetails($staffid);
        $subject = $this->objStaffdetails->getTodaysClass($staffid);
        $output['profile'] = $profile;
        $output['cards'] = $Cards;
        $output['depart'] = $Depart;
        $output['class'] = $subject;
        $output['eventincharge'] = $event;
        $output['eventvolunteer'] = $eventvolunteer;
        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function LoadStudentList() {
        $this->load->model('staff/staff_model', 'objStudentList');
        $name = $this->input->get('search');
        $studentlist = $this->objStudentList->GetSearchStudent($name);
        try {
            echo json_encode(array("results" => $studentlist));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function newtestingview() {
        $this->load->view('staff/staff_view/new');
    }

    /*     * ***************************Staff Attendance Module start***************************** */

    public function loadStaffAttView() {
        $this->load->view("staff/staff_view/staffattendance_view");
    }

    public function GetAttendence() {
        $date = $this->input->post('date');
        $date = changedateformate($date);
        if ($date <= date("Y-m-d")) {
            if ($this->session->userdata('staff_desig') == 'ADMIN') {
                $this->load->model('staff/staff_model', 'staff_model');
                $result1 = $this->staff_model->getStaffDetail('ALL');
                $result = $this->staff_model->GetStaffAttendence($this->session->userdata('staff_desig'), $result1, $date);
                try {
                    if ($result == 'HOLIDAY') {
                        echo printCustomMsg("ERRINPUT", "You can not mark today's attendance.Because today is holiday.", "-1");
                    } else if ($result == 'NOTADMIN') {
                        echo printCustomMsg("ERRINPUT", "You can not mark attendence.Because You are not an Admin", "-1");
                    } else {
                        echo printCustomMsg("TRUE", "Data Loaded Successfully", json_encode($result));
                    }
                } catch (Exception $exe) {
                    echo printCustomMsg('ERR', NULL, $exe->getMessage());
                }
            }
        } else {
            echo printCustomMsg("ERRINPUT", "Please select valid date .It must less than or equal to today date.", "-1");
        }
    }

    public function MarkAllAttendenceDetail() {
        $date = changedateformate($this->input->post('date'));
        if ($this->session->userdata('staff_desig') == 'ADMIN' && $date == date("Y-m-d")) {
            $myArr = json_decode($this->input->post('data'), true);
            $this->load->model('staff/staff_model', 'modelObj');
            $result = $this->modelObj->MarkAllAttendenceDetail($myArr, $date);
            if ($result == -1) {
                echo printCustomMsg("TRUESAVEERR");
            } else {
                echo printCustomMsg("TRUESAVE", null, $result);
            }
        } else {
            echo printCustomMsg("ERRINPUT", "Please select valid date .It must be equal to today's date", "-1");
        }
    }

    public function SaveStaffAttData() {
        $data = json_decode($this->input->post("data"), true);
        $date = changedateformate($data['date']);
        if ($this->session->userdata('staff_desig') == 'ADMIN' && $date == date("Y-m-d")) {
            $this->load->model('staff/staff_model', 'modelObj');
            $result = $this->modelObj->MarkStaffAtt($data, $date);
            if ($result == false) {
                echo printCustomMsg("TRUESAVEERR");
            } else {
                echo printCustomMsg("TRUESAVE", null, $result);
            }
        } else {
            echo printCustomMsg("ERRINPUT", "Please select valid date .It must be equal to today date", "-1");
        }
    }

    public function profilePictureUpload() {                              //Aman create this function for upload profile picture of staff
        $dbObj = json_decode($this->input->post('data'), true);
        $encodedImageData = str_replace(' ', '+', $dbObj['image']);
        $encodedImageData = str_replace('data:image/png;base64,', '', $dbObj['image']);
        $decodedImageData = base64_decode($encodedImageData);
        $uploadDirPath = 'uploads/' . $dbObj['randm_no'] . '/';
        $filePath = 'uploads/' . $dbObj['randm_no'] . '/' . time() . $dbObj['randm_no'] . '.png';
        if (!is_dir($uploadDirPath)) {
            mkdir($uploadDirPath, 0755, TRUE);
        }
        if (file_put_contents($filePath, $decodedImageData)) {
            echo printCustomMsg('UPLOAD', 'Image upload successfully.', $filePath);
        } else {
            echo printCustomMsg('UPLOADERROR', 'Image not upload successfully.', -1);
        }
    }

}
