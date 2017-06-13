<?php

class Marksentry_controller extends MY_Controller {

    public function index($subid = -1, $sectionid = -1, $examid = -1) {
        $allSubjectList = $this->GetAllSubjectList();
        if ($subid != -1 && $sectionid != -1 && $examid != -1) {
            $this->load->model('staff/marksentry_model', 'modelObj');
            $data = array('sub_id' => $subid, 'section_id' => $sectionid);
            $examlist = $this->modelObj->GetMyExamList($data);
        } else {
            $examlist = -1;
        }
        $this->load->view('staff/marks_view/marksentry_view.php', array('sub_id' => $subid, 'section_id' => $sectionid, 'examid' => $examid, 'examlist' => $examlist, 'allSubjctList' => $allSubjectList));
    }

    public function DeclareExam($class = -1) {
        $this->load->model('core/core', 'dbobj');
        $classList = $this->dbobj->getClassList();
        $this->load->view('staff/marks_view/declareexam_view.php', array("class" => $class, "myclassarr" => $classList));
    }

    public function GetAllSubjectList() {
        $this->load->model('staff/marksentry_model', 'modelObj');
        $staff_id = $this->session->userdata('staff_id');
        $subjectname = $this->modelObj->GetAllSubjectName($staff_id);
        try {
            return json_encode(array("subjectlist" => $subjectname));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetExamList() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $result = $this->modelObj->GetMyExamList($dataObj['detail']);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetExamPart() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $myexampart = $this->modelObj->GetMyExamPart($dataObj);
        try {
            echo json_encode(array("examPart" => $myexampart));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveExamPart() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $result = $this->modelObj->SaveMyExamPart($dataObj);
        if ($result) {
            echo printCustomMsg("TRUE", "Data Save successfully", $result);
        } else {
            echo printCustomMsg("SAVEERR", "Data not Save", $result);
        }
    }

    public function RemoveExamPart() {

        $data = json_decode($this->input->post('data'), TRUE);

        $this->load->model('staff/marksentry_model', 'modelObj');
        $result = $this->modelObj->RemoveMyExamPart($data);
        if ($result) {
            echo printCustomMsg("TRUE", "Remove  successfully", null);
        } else {
            echo printCustomMsg("SAVEERR", "Not Remove", null);
        }
    }

    public function SaveMarksDetail() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $result = $this->modelObj->SaveMyMarksDetail($dataObj);
        if ($result > 0) {
            echo printCustomMsg("TRUE", "Marks Update successfully", $result);
        } else {
            echo printCustomMsg("SAVEERR", "Marks not Update", $result);
        }
    }

    public function GetActualMarks() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('staff/marksentry_model', 'myModelObj');
        $result = $this->myModelObj->GetMyActualMarks($dataObj);
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveActualMarks() {
//        $data = $this->input->post('data');
//        $dataObj = json_decode($data);
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $result = $this->modelObj->SaveMyActualMarks($data);
        if ($result > 0) {
            echo printCustomMsg("TRUE", "Actual Marks Update successfully", $result);
        } else {
            echo printCustomMsg("SAVEERR", "Actual Marks not Update", $result);
        }
    }

//************************Publish Marks and Lock Marks Module Function***************


   public function PublishMarks() {
        $this->load->view('staff/marks_view/publishmarks_view.php');
    }
    
     public function GetClassList() {

        $this->load->model('core/core', 'coreObj');
        $classList = $this->coreObj->getActiveClassList();
        echo json_encode(array("classList" => $classList));
    }

    public function MarksDetails($Tabname, $classid = null) {
        $this->load->model('staff/marksentry_model', 'modelObj');
        if ($Tabname == 'PUBLISHMARKS') {
            $publishDetails = $this->modelObj->MyPublishMarksDetails($classid);
            $this->load->view('staff/marks_view/publishmarks_view.php', array('publishList' => $publishDetails, 'tabname' => $Tabname, 'classid' => $classid));
        } else {
            $lockDetails = $this->modelObj->MyLockMarksDetails($classid);
            $this->load->view('staff/marks_view/publishmarks_view.php', array('lockList' => $lockDetails, 'tabname' => $Tabname, 'classid' => $classid));
        }
    }

    public function SavePublishMarks() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $result = $this->modelObj->SaveMyPublishMarks($dataObj);
        try {
            if ($result != -1) {
                echo printCustomMsg("TRUE", "Marks Publish successfully", $result);
            } else {
                echo printCustomMsg("SAVEERR", "Marks not Publish", $result);
            }
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveLockMarks() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $result = $this->modelObj->SaveMyLockMarks($dataObj);
        try {
            if ($result) {
                echo printCustomMsg("TRUE", "Marks Lock successfully", $result);
            } else {
                echo printCustomMsg("SAVEERR", "Marks not Lock", $result);
            }
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

//***************************BlueSheet Module Function Start************************

    public function Bluesheet() {
        $this->load->view('staff/marks_view/bluesheet_view.php');
    }

    public function GetBlueExamList() {

        $data = json_decode($this->input->post('data'));
        $dataObj = json_decode($data);
        $this->load->model('core/core', 'coreObj');
        $classTeacher = $this->coreObj->getClassTeacher($dataObj);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $examList = $this->modelObj->GetMyNewExamList($dataObj);
        try {
            echo json_encode(array("examList" => $examList, "classTeacher" => $classTeacher));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function LoadExamMarks() {
        $data = json_decode($this->input->post('data'));
        $class = json_decode($data->class);
        $selectedExam = json_encode($data->exam);
        $selectedExam = json_decode($selectedExam);
        $this->load->model('staff/marksentry_model', 'modelObj');
        $finalResult = $this->modelObj->GetAllSubjectList($class, $selectedExam);
        try {
            echo json_encode($finalResult);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
