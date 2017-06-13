<?php

class marks_controller extends CI_Controller {

    public function GetStaffClass() {
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/marks_model', 'modelObj');
            $staffClass = $this->modelObj->getClassSubject($dataObj);
            echo json_encode(array('StaffClass' => $staffClass));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    
    public function GetSubjectExam() {
//        $postDataObj = json_decode('{"subject_id":"111","section_id":"15","staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/marks_model', 'modelObj');
            $subjectExam = $this->modelObj->getExamType($postDataObj['subject_id'],$postDataObj['section_id'],$dataObj);
            echo json_encode(array('SubjectExam' => $subjectExam));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    
    public function GetStudentSubjectMarks() {
//        $postDataObj = json_decode('{"section_id":"15","exam_id":"67","staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}',TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        if ($dataObj != -1) {
            $this->load->model('staffapp/marks_model', 'modelObj');
            $studentMarks = $this->modelObj->getMarksData($postDataObj['section_id'],$postDataObj['exam_id'], $dataObj);
            echo json_encode(array('marksData' => $studentMarks));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

}
