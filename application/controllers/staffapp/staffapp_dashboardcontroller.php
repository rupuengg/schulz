<?php

class staffapp_dashboardcontroller extends CI_Controller {

    public function getBirthday() {
        $postDataObj = json_decode($this->input->post('data'), true);
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $birthday = $this->modelObj->getBirthdayJson($dataObj);
            echo json_encode(array('birthday_detail' => $birthday));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getTodo() {
        $postDataObj = json_decode($this->input->post('data'), true);
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $todo = $this->modelObj->getTodoList($dataObj);
            echo json_encode(array('todo_detail' => $todo));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    
    // ******** new deletetodolist ************
     public function deleteTodo() {
        $postDataObj = json_decode($this->input->post('data'), true);
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $todo = $this->modelObj->deleteTodoList($postDataObj,$dataObj);
            echo json_encode(array('todo_detail' => $todo));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    
    // ******** END new deletetodolist ************
    public function getHomework() {
//        $postDataObj = json_decode($this->input->post('data'), true);
        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $homework = $this->modelObj->GetHomeworkdetail($dataObj);
            echo json_encode(array('homework_detail' => $homework));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getExamDateSheet() {
        $postDataObj = json_decode($this->input->post('data'), true);
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $examdatesheet = $this->modelObj->GetExamDatesheet($dataObj);
            echo json_encode(array('examdatesheet_detail' => $examdatesheet));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getNotice() {
//        $postDataObj = json_decode($this->input->post('data'), true);
        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
         //echo '<pre>'; print_r($dataObj); exit;
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $noticelist = $this->modelObj->getNoticeList($dataObj);
            echo json_encode(array('notice_detail' => $noticelist));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getEvent() {
//        $postDataObj = json_decode($this->input->post('data'), true);
        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $eventlist = $this->modelObj->getEventList($dataObj);
            echo json_encode(array('event_detail' => $eventlist));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getCardCount() {
        $postDataObj = json_decode($this->input->post('data'), true);
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $cardlist = $this->modelObj->GetCardCount($dataObj);
            echo json_encode(array('cardcount_detail' => $cardlist));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getUpcomingHoliday() {
        $postDataObj = json_decode($this->input->post('data'), true);
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
            $holidayList = $this->modelObj->GetUpComingHoliday($dataObj);
            echo json_encode(array('holidayData' => $holidayList));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    
    public function getCardDet() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
//        $postDataObj = json_decode('{"card_type":"BLUE","staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        $this->load->model('staffapp/appstaffdashboard_model', 'modelObj');
        $cardDet = $this->modelObj->GetCardDetail($postDataObj['card_type'], $dataObj);
        echo json_encode(array('cardstu_detail' => $cardDet));
    }

}
