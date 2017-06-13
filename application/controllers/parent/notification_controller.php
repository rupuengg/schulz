<?php

class notification_controller extends MY_Controller {

    public function GetNotification() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/notification_model', 'modelObj');
        $result = $this->modelObj->GetAllNotifications($dataObj);
        echo json_encode($result);
    }
    public function allnotification() {
        $this->load->view('parent/notification/notification_view'); 
    }
    public function notificationdata() {
        $this->load->model('parent/notification_model','notiObj');
        $data = $this->notiObj->GetAllNotifications();
         echo json_encode($data);
    }
}
