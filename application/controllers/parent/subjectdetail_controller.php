<?php

class subjectdetail_controller extends MY_Controller {
    
    public function subjectdata($sub_id) {
        $this->load->model('parent/subjectdetail_model', 'modelObj');
        $result = $this->modelObj->subjectDetail($sub_id);
        $this->load->view('parent/subject_view/subject_view', array("subjectData" => $result));
    }

    public function markstructure() {
        $examid = json_decode($this->input->post('data'), true);
        $this->load->model('parent/subjectdetail_model', 'modelObj');
        $result = $this->modelObj->examPartDetail($examid);
        echo json_encode($result);
    }

}
