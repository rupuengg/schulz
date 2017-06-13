<?php

class appcard_model extends CI_Model {

    public function GetCardDetails($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj->select("remarks,DATE_FORMAT(`card_issue_date`, '%D %M, %Y') as issue_date,card_type,entry_by,timestamp", FALSE);
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->limit(10);
        $cardDetails = $dbObj->get_where('cards_details', array('adm_no' => $dataObj['adm_no'], 'approved_status' => 'YES'))->result_array();

        $arrFinalCardDetails = array();
        $i = 0;
        if (!empty($cardDetails)) {
            foreach ($cardDetails as $row) {
                $staff_detail = $this->coreObj->GetStaffName($row['entry_by'], $dbObj);
                $arrCard = array();
                $arrCard = array('timestamp' => $row['timestamp'], 'card_type' => $row['card_type'], 'remarks' => $row['remarks'], 'date' => 'Got ' . $row['card_type'] . ' on ' . $row['issue_date'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id'], 'staff_pic' => base_url() . 'index.php/app/getstaffphoto/' . $staff_detail['id'] . '/THUMB');
                $arrFinalCardDetails[$i] = $arrCard;
                $i++;
            }
            return $arrFinalCardDetails;
        } else {
            return 0;
        }
    }

    public function GetCardCount($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('lower(card_type) as card_name,count(card_type) as count');
        $dbObj->from('cards_details');
        $dbObj->where('adm_no', $dataObj['adm_no']);
        $dbObj->where('approved_status', 'YES');
        $dbObj->group_by('card_type');
        $cardCount = $dbObj->get()->result_array();
        $staffCount = $this->GetCountCardIssueByStaff($dataObj['adm_no'], $dbObj);
        $arrFinalCardCount = array();
        $arrFinalCardCount['studentName'] = ucfirst(strtolower($dataObj['firstname'])) . ' ' . ucfirst(strtolower($dataObj['lastname'])) . " 's Cards ";
        $arrFinalCardCount['cardcount'] = $cardCount;
        $arrFinalCardCount['staffcount'] = $staffCount;
        return $arrFinalCardCount;
    }

    public function GetCountCardIssueByStaff($adm_no, $dbObj) {
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj->select('card_type,count(card_type) as count,entry_by as staff_id');
        $dbObj->from('cards_details');
        $dbObj->where('adm_no', $adm_no);
        $dbObj->where('approved_status', 'YES');
        $dbObj->group_by('entry_by');
        $staffCount = $dbObj->get()->result_array();
        if (!empty($staffCount)) {
            for ($i = 0; $i < count($staffCount); $i++) {
                $staff_detail = $this->coreObj->GetStaffName($staffCount[$i]['staff_id'], $dbObj);
                $staffCount[$i]['staff_name'] = $staff_detail['name'];
                $staffCount[$i]['staff_pic'] = base_url() . 'index.php/app/getstaffphoto' . $staff_detail['id'] . '/THUMB';
            }
            return $staffCount;
        } else {
            return 0;
        }
    }

}
