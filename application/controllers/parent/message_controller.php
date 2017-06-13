<?php

class message_controller extends MY_Controller {

    public function LoadView($staff_id = -1) {
        $this->load->model('parent/message_model', 'modelObj');
        $this->load->model('parent/parent_core', 'coreObj');
        $staffDeatil=$this->coreObj->GetStaffName($staff_id);
        if(!empty($staffDeatil)){
           $staffName= $staffDeatil['name'];
        }else{
            $staffName= '';
        }
        $myMessageDeatil = $this->modelObj->GetMyMessage($staff_id);
        $this->load->view('parent/message_view/message_view', array('myMessageDeatil' => $myMessageDeatil,'staff_name'=>$staffName, 'staff_id' => $staff_id));
    }

    public function GetMessage() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/message_model', 'modelObj');
        $messageResult = $this->modelObj->GetMessageDetails($dataObj);
        echo json_encode($messageResult);
    }

    public function SendMessage() {
        $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $messageContentObj = json_decode($this->input->post('data'));
        $this->load->model('parent/message_model', 'modelObj');
        $result = $this->modelObj->SendMessages($messageContentObj, $dataObj);
        if ($result > 0) {
            echo printCustomMsg("TRUE", "Message Sent Successfully", $result);
        } else {
            echo printCustomMsg("ERRINPUT", "Something was wrong,Please try again..!", $result);
        }
    }

    public function UpdatedMessage() {
        $staff_id = json_decode($this->input->post('data'));
        $this->load->model('parent/message_model', 'modelObj');
        $myMessageDeatil = $this->modelObj->GetMyMessage($staff_id);
        echo json_encode($myMessageDeatil);
    }

}
