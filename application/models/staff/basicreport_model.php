<?php

class basicreport_model extends CI_Model {

    public function GetHouseList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,house_name');
        $houseList = $dbObj->get('house_list')->result_array();
        return $houseList;
    }

    public function GetCardDetails() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->distinct('card_type');
        $dbObj->select('card_type');
        $cardList = $dbObj->get("cards_details")->result_array();
        return $cardList;
    }

}
