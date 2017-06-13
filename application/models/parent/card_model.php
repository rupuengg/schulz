<?php

class card_model extends CI_Model {

    public function GetCardDetails($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select('remarks,card_issue_date as issue_date,card_type,entry_by,timestamp');
        $dbObj->order_by('timestamp', 'desc');
        $cardDetails = $dbObj->get_where('cards_details', array('adm_no' => $dataObj['adm_no'], 'approved_status' => 'YES'))->result_array();
        $arrFinalCardDetails = array();
        $i = 0;
        if (!empty($cardDetails)) {
            foreach ($cardDetails as $row) {
                $staff_id = $row['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id);
                $arrCard = array();
                $arrCard['timestamp'] = $row['timestamp'];
                $arrCard['type'] = 'CARD';
                $arrCard['data'] = array('card_type' => $row['card_type'], 'remark' => $row['remarks'], 'issue_date' => $row['issue_date'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id']);
                $arrFinalCardDetails[$i] = $arrCard;
                $i++;
            }
            return $arrFinalCardDetails;
        } else {
            return 0;
        }
    }

    public function GetCardCount($dataObj) {
        $adm_no = $dataObj['adm_no'];
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('lower(card_type) as card_name,count(card_type) as count');
        $dbObj->from('cards_details');
        $dbObj->where('adm_no', $adm_no);
        $dbObj->where('approved_status', 'YES');
        $dbObj->group_by('card_type');
        $cardCount = $dbObj->get()->result_array();
        $staffCount = $this->GetCountCardIssueByStaff($adm_no);
        $arrFinalCardCount = array();
        $arrFinalCardCount['cardcount'] = $cardCount;
        $arrFinalCardCount['staffcount'] = $staffCount;
        return $arrFinalCardCount;
    }

    public function GetCountCardIssueByStaff($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select('card_type,count(card_type) as count,entry_by');
        $dbObj->from('cards_details');
        $dbObj->where('adm_no', $adm_no);
        $dbObj->where('approved_status', 'YES');
        $dbObj->group_by('entry_By');
        $staffCount = $dbObj->get()->result_array();
        if (!empty($staffCount)) {
            for ($i = 0; $i < count($staffCount); $i++) {
                $staff_id = $staffCount[$i]['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id);
                $staffCount[$i]['staff_name'] = $staff_detail['name'];
                $staffCount[$i]['staff_id'] = $staff_detail['id'];
            }
            return $staffCount;
        } else {
            return 0;
        }
    }

}
