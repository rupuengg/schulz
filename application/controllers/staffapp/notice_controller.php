<?php

class notice_controller extends CI_Controller {

    public function NoticeGet() {
        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
//        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
         $this->load->model('staffapp/notice_model', 'modelObj');
        if ($dataObj != -1) {
            $noticlist = $this->modelObj->GetNotice($dataObj);
            echo json_encode(array('admin_notice' => $noticlist));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function total_staff_stu_count() {
//        $postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
        $this->load->model('staffapp/notice_model', 'modelObj');
        if ($dataObj != -1) {
            $noticeStaffCountlist = $this->modelObj->GetStaffNoticeCount($dataObj);
            echo json_encode(array('admin_notice_count' => $noticeStaffCountlist));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function saveNoticeSendDetail() {
        //$postDataObj = json_decode('{"staff_id":"1","access_key":"4G43UZ8PXC4H4LW8T9BURDHH0TD441SY8MRSBQ6YS15MCTKVSMF8QOGG6JA1BTPA","notice_title":"HOLIDAY","notice_type":"Allstudent","notice_msg":"inform to all staff and student"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
       // echo json_encode($postDataObj);
        if ($postDataObj['notice_title']== '' || $postDataObj['notice_type'] == '' ||$postDataObj['notice_msg'] == '') {
           echo printCustomMsg('ERROR', 'Please fill data correctly..', -1);
        } else {
            $this->load->model('staffapp/staffapp_core', 'coreObj');
            $dataObj = $this->coreObj->GetStaffDatabaseName($postDataObj['staff_id'], $postDataObj['access_key']);
            if ($dataObj != -1) {
                $this->load->model('staffapp/notice_model', 'modelObj');
                $insertid = $this->modelObj->saveNoticeSendDetail($dataObj, $postDataObj);
                if ($insertid > 0) {
                    echo printCustomMsg('SAVE', 'Notice sent successfully..', $insertid);
                } elseif ($insertid == 'INVALIDTYPE') {
                    echo printCustomMsg('ERR', 'Notice type is not valid...', $insertid);
                } else {
                    echo printCustomMsg('ERR', 'Database error,contact to admin..', $insertid);
                }
            } else {
                echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
            }
        }
    }

}
