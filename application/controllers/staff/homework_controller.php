<?php

class homework_controller extends MY_Controller {

    public function LoadHomework($hw_id = NULL) {
        $this->load->view('staff/homework/homework_view', array("pagetype" => 'HOMEWORK', 'hw_id' => $hw_id));
    }

    public function LoadAssigment() {
        $this->load->view('staff/homework/assigment_view', array("pagetype" => 'ASSIGNMENT'));
    }

    public function MyStaffData() {
        $this->load->model('staff/homework_model', 'modelObj');
        $result = $this->modelObj->TeacherSubjectList();
        $output = array();
        $output['staffdata'] = $result;
        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function Loaddata() {
        $myInputArr = json_decode($this->input->post('data'), true);
        $this->load->model('staff/homework_model', 'modelObj');
        $resultdata = $this->modelObj->Loadhwmodel($myInputArr);
        try {
            echo json_encode($resultdata);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function HwPostData() {
        $mypostArr = json_decode($this->input->post('data'), true);
        if ($mypostArr['title'] != '' && $mypostArr['date'] != '' && $mypostArr['lastsubmissiondate'] != '') {
//            $this->do_upload($mypostArr['importFiles'][0]);
            $this->load->model('staff/homework_model', 'modelObj');
            $result = $this->modelObj->posthomework($mypostArr);
            if ($result == -1) {
                echo json_encode(array("type" => "SAVEERROR", "message" => "NOT SAVE", "value" => 1));
            } else {
                echo json_encode(array("type" => "SAVE", "message" => "SAVE", "value" => $result));
            }
        } else {
            echo json_encode(array("type" => "SAVEERROR", "message" => "NOT SAVE", "value" => 1));
        }
    }

    public function Homeworkdetail() {
        $hw_id = json_decode($this->input->post('data'), true);
        $this->load->model('staff/homework_model', 'modelObj');
        $hwresult = $this->modelObj->hwdetail($hw_id);
        try {
            echo json_encode($hwresult);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function Loadsectionclass() {
        $this->load->model('core/core', 'modelObj');
        $sectionresult = $this->modelObj->GetAllSection();
        try {
            echo json_encode($sectionresult);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function LoadClassStudent() {
        $stdsection_id = json_decode($this->input->post('data'), true);
        $this->load->model('staff/homework_model', 'modelObj');
        $resultallstd = $this->modelObj->StudeltAll($stdsection_id);
        try {
            echo json_encode($resultallstd);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function FullAssignmentDetail() {
        $hw_id = json_decode($this->input->post('data'), true);
        $this->load->model('staff/homework_model', 'modelObj');
        $fulldetail = $this->modelObj->GetFullAssignmentDetail($hw_id);
        try {
            echo json_encode($fulldetail);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function Loadstudetails() {
        $adm_no = json_decode($this->input->post('data'), true);
        $this->load->model('staff/homework_model', 'modelObj');
        $studdetresult = $this->modelObj->Getstuddet($adm_no);
        try {
            echo json_encode($studdetresult);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function MyFileUpload($uploadStr) {

        if (!empty($_FILES)) {
            restart:
            $tempPath = $_FILES['file']['tmp_name'];
            $filetype = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $session = $this->db->get_where('school_db_year_wise', array('school_code' => $this->session->userdata('school_code'), 'current_db' => 'YES'))->row_array();
            $session = $session['start_year'] . '_' . $session['end_year'];
            $school_code = $this->session->userdata('school_code');
            $month_name = date('m-y');
            $filePath = 'files/' . $school_code . '/' . $session . '/homework/' . $month_name . '/' . $uploadStr;
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, TRUE);
            }
            $pathToUpload = 'files/' . $school_code . '/' . $session . '/homework/' . $month_name . '/' . $uploadStr . DIRECTORY_SEPARATOR . $_FILES['file']['name'];
            $this->load->model('staff/homework_model', 'modelObj');
            $fileId = $this->modelObj->MyFileUploads($pathToUpload, $_FILES['file']['name'], $filetype, $uploadStr);
            if ($fileId > 0) {
                move_uploaded_file($tempPath, $pathToUpload);
                $result = array('answer' => 'File transfer completed', 'file_id' => $fileId,);
                echo json_encode($result);
            }
        } else {
            echo 'No files';
        }
    }

}
