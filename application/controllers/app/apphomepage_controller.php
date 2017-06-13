<?php

class apphomepage_controller extends CI_Controller {

    public function LoadHomepageData() {
       // $postDataObj = json_decode($this->input->post('data'), TRUE);
        $postDataObj =  json_decode('{"adm_no":"1241","access_key":"FG0P9OJECOQWLLMH2FSIZ0JHRS5S0AQ5GGKFUVKW80JJCWS529ES0O0H6VZXVFS2"}',TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/apphomepage_model', 'modelObj');
            $upcomingData = $this->modelObj->GetUpComingNews($dataObj);
            $notification = $this->modelObj->GetNotifications($dataObj);
            $holidayList = $this->modelObj->GetUpComingHoliday($dataObj);
            if ($holidayList && $notification && $upcomingData) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('notificationData' => $notification, 'upcomingData' => $upcomingData, 'holidayList' => $holidayList));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }

//        echo json_encode(array('notificationData' => $notification, 'upcomingData' => $upcomingData, 'holidayList' => $holidayList));
    }

}
