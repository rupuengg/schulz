<?php

class appnotification_controller extends CI_Controller {

    public function LoadNotificationData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appnotification_model', 'modelObj');
            $resultJsonNotification = $this->modelObj->GetAllNotifications($dataObj);
            if ($resultJsonNotification) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('notificationDeatil' => $resultJsonNotification));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
