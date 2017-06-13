<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cards_controller extends MY_Controller {

    public function LoadCards() {
        $this->load->view('parent/cards_view/cards.php');
    }

    public function GetLoadCardDetails() {
       $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/card_model', 'modelObj');
        $cardDeatils = $this->modelObj->GetCardDetails($dataObj);
        echo json_encode($cardDeatils);
    }

    public function CardCountDetail() {
      $this->load->model('parent/parent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $this->load->model('parent/card_model', 'modelObj');
        $cardCount = $this->modelObj->GetCardCount($dataObj);
        echo json_encode($cardCount);
    }

}
