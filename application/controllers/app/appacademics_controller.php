<?php

class appacademics_controller extends CI_Controller {

    public function Index() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appacademics_model', 'modelObj');
            $stuMarks = $this->modelObj->LoadStudentMarks($dataObj);
            $graphData = $this->modelObj->GetGraphData($dataObj);
            if ($stuMarks && $graphData) {
                echo printCustomMsg('TRUE', 'Data Load successfully..', array('marks_detail' => $stuMarks, 'graphData' => $graphData));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
    }

}
