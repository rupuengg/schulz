<?php

class sqlreport_model extends CI_Model {

    public function GetSearchField() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $finalArr = array();
        $fields = $dbObj->list_fields('biodata');
        $finalArr['field']['name'] = $fields;
        return $finalArr;
    }

    public function GetSearchResult($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if (isset($dataObj)) {
            $newData = json_decode($dataObj);
            $dataArray = json_decode(json_encode($newData), true);
            $arrselecttemp = array();
            foreach ($dataArray['select'] as $row) {
                $arrselecttemp[] = $row;
            }
            $selectCol = implode(',', $arrselecttemp);
            $dbObj->select("$selectCol");
            if(isset($dataArray['where'])){
            $dbObj->like($dataArray['where'],'after');
            }
            $searchresult = $dbObj->get('biodata')->result_array();
            $colvalue = array();
            $k = 0;
            for ($j = 0; $j < count($searchresult); $j++) {
                $colvalue[$k] = array_values($searchresult[$j]);
                $k++;
            }
            if (!empty($colvalue)) {
                return $colvalue;
            } else {
                return -1;
            }
        }
    }

}
