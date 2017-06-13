<?php

class Notice_controller extends MY_Controller {

    public function index() {
        $this->load->view('staff/notice/notice_view.php');
    }

    public function GetNoticeDeatil() {
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        if (!$dataObj) {
            echo "not parse";
        }
        $this->load->model('staff/notice_model', 'modelObj');
        $result = $this->modelObj->NoticeDetail($dataObj);
        if ($result > 0) {
            echo printCustomMsg("TRUE", "Notice Send successfully", $result);
        } else {
            echo printCustomMsg("SAVEERR", "Notice not Send", $result);
        }
    }

    public function NoticeSendDirect() {
        $id = 'ALL';
        $section_id = 'ALL';
        $data = $this->input->post('data');
        $dataObj = json_decode($data);
        if ($dataObj->type == 'ALLSTAFF') {
            $this->load->model('staff/staff_model', 'staffModelObj');
            $resultDirect = $this->staffModelObj->GetStaffDetail($id);
            $this->load->model('staff/notice_model', 'modelObj');
            $result = $this->modelObj->DirectNoticeSend($dataObj, $resultDirect);
            if ($result > 0) {
                echo printCustomMsg("TRUE", "Notice Send successfully", $result);
            } else {
                echo printCustomMsg("SAVEERR", "Notice not Send", $result);
            }
        } else if ($dataObj->type == 'ALLSTUDENT') {
            $this->load->model('core/core', 'modelObj');
            $resultDirect = $this->modelObj->GetAllStudent($section_id);
            $this->load->model('staff/notice_model', 'modelStuObj');
            $result = $this->modelStuObj->DirectNoticeSend($dataObj, $resultDirect);
            if ($result > 0) {
                echo printCustomMsg("TRUE", "Notice Send successfully", $result);
            } else {
                echo printCustomMsg("SAVEERR", "Notice not Send", $result);
            }
        } else if ($dataObj->type == 'SCHOOL') {
            $this->load->model('staff/staff_model', 'staffModelObj');
            $resultDirect = $this->staffModelObj->GetStaffDetail($id);
            $this->load->model('core/core', 'modelObj');
            $resultDirect1 = $this->modelObj->GetAllStudent($section_id);
            $this->load->model('staff/notice_model', 'modelAllObj');
            $result = $this->modelAllObj->DirectNoticeSendAll($dataObj, $resultDirect, $resultDirect1);
            if ($result > 0) {
                echo printCustomMsg("TRUE", "Notice Send successfully", $result);
            } else {
                echo printCustomMsg("SAVEERR", "Notice not Send", $result);
            }
        }
    }

}
