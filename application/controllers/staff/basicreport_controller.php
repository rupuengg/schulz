<?php

class basicreport_controller extends MY_Controller {

    public function AbsentStudentReport($att_date = '') {
        if ($att_date != '') {
            $att = urldecode($att_date);
            $json = json_decode($att, true);
            $attdate = $json['attdate'];
            list( $year, $month, $day) = explode('-', $attdate);
            $att_date = sprintf('%s-%s-%s', $year, $month, $day);
        }
        try {
            $this->load->view('staff/basicreport_view/absentstudentreport_view', array("attDate" => $att_date));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function ClassListReport($class = -1) {
        $this->load->model('core/core', 'dbobj');
        $sectionList = $this->dbobj->GetAllSection();
        try {
            $this->load->view('staff/basicreport_view/classlistreport_view', array("class" => $class, "sectionList" => $sectionList));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function HouseReport($houseName = 'ALL') {
        $this->load->model('staff/basicreport_model', 'modelObj');
        $houseList = $this->modelObj->GetHouseList();
        try {
            $this->load->view('staff/basicreport_view/housereport_view', array("houseList" => $houseList, "houseName" => $houseName));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function LateStudentReport($att_date = '') {
        if ($att_date != '') {
            $att = urldecode($att_date);
            $json = json_decode($att, true);
            $attdate = $json['attdate'];
            list( $year, $month, $day) = explode('-', $attdate);
            $att_date = sprintf('%s-%s-%s', $year, $month, $day);
        }
        try {
            $this->load->view('staff/basicreport_view/latestudentreport_view', array("attDate" => $att_date));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function CardListReport($fromdate = '', $todate = '', $cardName = '') {
        $this->load->model('staff/basicreport_model', 'modelObj');
        $cardList = $this->modelObj->GetCardDetails();
        try {
            $this->load->view('staff/basicreport_view/cardlistreport_view', array("cardList" => $cardList, "cardName" => $cardName, "fromDate" => $fromdate, "toDate" => $todate));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
