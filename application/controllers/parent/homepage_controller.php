<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class homepage_controller extends MY_Controller {

    public function Loadhomepage() {
        $adm_list = $this->session->userdata('adm_no_list');
        $studentList = array();
        $this->load->model('parent/parent_core', 'coreObj');
        for ($i = 0; $i < count($adm_list); $i++) {
            $studentList[] = $this->coreObj->GetParentStudent($adm_list[$i]);
        }
        $this->load->view('parent/homepage_view/homepage.php',array("studentList"=>$studentList));
    }

    public function GetNewsUpdate() {
        $this->load->model('parent/homepage_model', 'modelObj');
        $result = $this->modelObj->GetUpComingNews();
        echo json_encode($result);
    }

    public function GetHolidayList() {
        $this->load->model('parent/homepage_model', 'modelObj');
        $result = $this->modelObj->GetUpComingHoliday();
        echo json_encode($result);
    }

    public function GetNotification() {
        $this->load->model('parent/homepage_model', 'modelObj');
        $result = $this->modelObj->GetNotifications();
        echo json_encode($result);
    }

}
