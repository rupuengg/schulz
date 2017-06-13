<?php
class admindashboard_controller extends CI_Controller {

    public function MainData() {
        //$postDataObj = json_decode($this->input->post('data'), TRUE);
        $postDataObj = json_decode('{"staff_id":"1","school_code":"TESTDB","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        $this->load->model('staffapp/admindashboard_model', 'modelObj');
        if ($dataObj != -1) {            
            $card = $this->modelObj->GetCardCount($dataObj);             
            $holidays = $this->modelObj->UpComingHoliday($dataObj);
            $getBirthday = $this->modelObj->getBirthdayJson($dataObj);
            $examdtesht = $this->modelObj->GetExamDatesheet($dataObj);
            $event = $this->modelObj->GetEvent($dataObj);           
            $notice = $this->modelObj->getNoticeList($dataObj);
            $library = $this->modelObj->getLibData($dataObj);
            $lateentry = $this->modelObj->getLateData($dataObj);
            $fees = $this->modelObj->getFeesData($dataObj);
            $attdata = $this->modelObj->getAttData($dataObj);
            $Login = $this->modelObj->getLogin($dataObj, $postDataObj['school_code']);
            $WeeklyLogin = $this->modelObj->getWeeklyLogin($dataObj,$postDataObj['school_code']);
            $WeeklyAttndnc = $this->modelObj->getWeeklyAttndnc($dataObj,$postDataObj['school_code']);
            $fnal_arr = array('att_data' => $attdata, 'login' => $Login, 'cards' => $card, 'holiday' => $holidays, 'late_entry' => $lateentry, 'birthday' => $getBirthday, 'exmdtsht' => $examdtesht, 'lib' => $library, 'event' => $event, 'notice' => $notice, 'Fees' => $fees,'weekly_attdce'=>$WeeklyAttndnc,'weekly_login'=>$WeeklyLogin);
           echo json_encode(array('dashboard' => $fnal_arr));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getUpcomingBirthday() {
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $commingbirthday = $this->modelObj->getBirthday($dataObj);
            for ($i = 0; $i < count($commingbirthday); $i++) {
                if ($commingbirthday[$i]['type'] == 'STAFF') {
                    $staff[] = array('staff_name' => $commingbirthday[$i]['firstname'] . ' ' . $commingbirthday[$i]['lastname'], 'budday_date' => $commingbirthday[$i]['day'], 'staff_pic' => base_url() . "index.php/app/getstaffphoto/" . $commingbirthday[$i]['id'] . "/THUMB");
                } else {
                    $stud_det = $this->coreObj->GetStudentDetail($commingbirthday[$i]['adm_no'], $dbObj);
                    $stud[] = array('stud_name' => $stud_det['student_name'] . '(' . $stud_det['class'] . ')', 'budday_date' => $commingbirthday[$i]['day'], 'staff_pic' => $stud_det['student_pic']);
                }
            }
            $upcomingbday = array('staff' => $staff, 'student' => $stud);
            echo json_encode(array('Upcoming_Birthday' => $upcomingbday));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    public function getrcntlyLogin() {
//        $postDataObj = json_decode('{"staff_id":"1","school_code":"TESTDB","staff_desig":"ADMIN","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1 && $postDataObj['staff_desig'] == strtoupper('admin')) {
            $this->load->model('staffapp/admindashboard_model', 'modelObj');
            $rcntlylist = $this->modelObj->getRecntlyLogin($dataObj,$postDataObj['school_code']);
            echo json_encode(array('recntly_login' => $rcntlylist));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

}
