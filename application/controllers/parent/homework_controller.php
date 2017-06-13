<?php

class homework_controller extends MY_Controller {

    public function LoadHomeworkView($hw_id = -1) {
        $this->load->model('parent/homework_model', 'modelObj');
        $homeWorkDeatils = $this->modelObj->GetMyHomeworkDetail($hw_id);
        $this->load->view('parent/homework_view/homework_view', array("homeWorkFulldeatils" => $homeWorkDeatils));
    }

    public function GetStudentHomework() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/homework_model', 'modelObj');
        $result = $this->modelObj->GetMyHomeworkData($dataObj);
        echo json_encode($result);
    }

}
