<?php

class appcards_controller extends CI_Controller {

    public function LoadCardData() {
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        if (!empty($postDataObj)) {
            $this->load->model('app/appparent_core', 'coreObj');
            $dataObj = $this->coreObj->GetStudentDatabaseName($postDataObj['adm_no'], $postDataObj['access_key']);
            $this->load->model('app/appcard_model', 'modelObj');
            $resultJsonCard = $this->modelObj->GetCardDetails($dataObj);
            $resultCardCount = $this->modelObj->GetCardCount($dataObj);
            if ($resultJsonCard && $resultCardCount) {
                echo printCustomMsg('TRUE', 'Data load succssfully', array('studentName' => $resultCardCount['studentName'], 'cards_count' => $resultCardCount['cardcount'], 'card_issued_by_teachers' => $resultCardCount['staffcount'], 'full_card_details' => $resultJsonCard));
            } else {
                echo printCustomMsg('ERRLOAD');
            }
        } else {
            echo printCustomMsg('ERRINPUT');
        }
//        echo json_encode(array('studentName' => $resultCardCount['studentName'], 'cards_count' => $resultCardCount['cardcount'], 'card_issued_by_teachers' => $resultCardCount['staffcount'], 'full_card_details' => $resultJsonCard));
    }

}
