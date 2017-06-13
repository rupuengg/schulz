<?php

class reportcard_controller extends CI_Controller {

    public function index() {
        $this->load->view('staff/reportcard/report_card_view.php');
    }

    public function secondrystudentreport() {
        $this->load->view('staff/reportcard/reportCard_Student_view.php');
    }

    public function getstandard() {

        $data = $this->input->post('data');
        $this->load->model('staff/reportcard_model', 'codeModelObj');
        $standardsection = $this->codeModelObj->GetstandardSection($data);
        $standard = $standardsection['standard'];
        $section = $standardsection['section'];
        try {
            echo json_encode(array("standard" => $standard, "section" => $section));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function CreateDirectry($dataObj, $primarypdfUrl, $secondrypdfUrl = NULL) {
        if ($secondrypdfUrl == NULL) {
            $secndrydivsnpdf = convertHtmlToPdf($primarypdfUrl);
            if (!is_dir("assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/")) {
                mkdir("assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/", 0755, true);
            }
            $secndrydivsnPath = "assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/" . $dataObj['adm_no'] . "_reportcrd.pdf";

            if (file_exists($secndrydivsnPath)) {
                unlink($secndrydivsnPath);
            }
            if (!file_exists($secndrydivsnPath)) {
                if (file_put_contents("assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/" . $dataObj['adm_no'] . "_reportcrd.pdf", file_get_contents($secndrydivsnpdf))) {
                    return 'SUCCESS';
                } else {
                    echo printCustomMsg('ERR');
                }
            } else {
                return 'ALLREADY';
            }
        } else {
            $junrprimarypdfUrl = convertHtmlToPdf($primarypdfUrl);
            $junrsecondrypdfUrl = convertHtmlToPdf($secondrypdfUrl);
            try {
                if (!is_dir("assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/")) {
                    mkdir("assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/", 0755, true);
                }
                $primaryPath = "assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/" . $dataObj['adm_no'] . "_primary.pdf";
                $secondryPath = "assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/" . $dataObj['adm_no'] . "_secondry.pdf";
                if (file_exists($primaryPath) && file_exists($secondryPath)) {
                    unlink($primaryPath);
                    unlink($secondryPath);
                }
                if (!file_exists($primaryPath) && !file_exists($secondryPath)) {
                    file_put_contents("assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/" . $dataObj['adm_no'] . "_primary.pdf", file_get_contents($junrprimarypdfUrl));
                    file_put_contents("assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $dataObj['section_id'] . "/" . $dataObj['adm_no'] . "/" . $dataObj['adm_no'] . "_secondry.pdf", file_get_contents($junrsecondrypdfUrl));
                    return 'SUCCESS';
                } else {
                    return 'ALLREADY';
                }
            } catch (Exception $exe) {
                echo printCustomMsg('ERR', NULL, $exe->getMessage());
            }
        }
    }

    public function GetReportCardBothSideData() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        if ($dataObj['division'] == 'SENIOR') {
            $secndrystucardpdf = base_url() . "index.php/staff/studentreportcard/" . $dataObj['adm_no'] . '/' . $dataObj['section_id'] . '/' . $dataObj['school_code'];
            $result = $this->CreateDirectry($dataObj, $secndrystucardpdf);
        } else {
            $studentCardPrimaryPdf = base_url() . "index.php/staff/primarycard/" . $dataObj['adm_no'] . '/' . $dataObj['section_id'] . '/' . $dataObj['school_code'];
            $studentCardSecondryPdf = base_url() . "index.php/staff/secondrycard/" . $dataObj['adm_no'] . '/' . $dataObj['section_id'] . '/' . $dataObj['school_code'];
            $result = $this->CreateDirectry($dataObj, $studentCardPrimaryPdf, $studentCardSecondryPdf);
        }
        try {
            if ($result == 'SUCCESS') {
                echo printCustomMsg('SUCCESS', "Result pdf genrated.", $dataObj['adm_no']);
            } else {
                echo printCustomMsg('ALLREADY', "Result pdf already genrated.", $dataObj['adm_no']);
            }
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getReportCardSecondry($adm_no, $section_id, $school_code) {
        $dataObjArr = array('adm_no' => $adm_no, 'section_id' => $section_id, 'school_code' => $school_code);
        $this->load->model('staff/reportcard_model', 'modelObj');
        $result = $this->modelObj->GetStudentReportCardData($dataObjArr);
        try {
            $this->load->view('staff/reportcard/reportCard_Student_primary_view2', array('reportCardData' => $result, 'data' => $dataObjArr));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getReportCardPrimary($adm_no, $section_id, $school_code) {
        $dataObjArr = array('adm_no' => $adm_no, 'section_id' => $section_id, 'school_code' => $school_code);
        $this->load->model('staff/reportcard_model', 'modelObj');
        $result = $this->modelObj->GetStudentReportCardPrimaryData($dataObjArr);
        try {
            $this->load->view('staff/reportcard/reportCard_Student_primary_view', array('primary' => $result, 'school_code' => $school_code));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getSecndryReportCard($adm_no, $section_id, $school_code) {
        $dataObjArr = array('adm_no' => $adm_no, 'section_id' => $section_id, 'school_code' => $school_code);
        $this->load->model('staff/reportcard_model', 'modelObj');
        $result = $this->modelObj->getSecndryReportCard($dataObjArr);
        try {
            $this->load->view('staff/reportcard/reportCard_Student_view', array('primary' => $result));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function DownloadreportCard($type = 'ALL') {
        if ($type == 'ALL') {
            $data = json_decode($this->input->post('data'), TRUE);
            if ($data['type'] == 'ALL') {
                $tepPath = "assets/temp/" . $data['section_id'];
                if (!is_dir($tepPath)) {
                    mkdir($tepPath, 0755, true);
                }
                $filePath = "assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $data['section_id'];
                if (is_dir($tepPath)) {
                    copy_directory($filePath, $tepPath);
                    GetZipFoderPath($tepPath);
                    echo printCustomMsg('DOWNLOAD', 'Zip created ready to download..', $data['section_id']);
                } else {
                    echo printCustomMsg('PATHRROR', 'File Path not create ', -1);
                }
            } else {
                foreach ($data['array_data'] as $value) {
                    $dwnld_path = "Partial/" . $data['section_id'];
                    $tepPath = "assets/temp/" . $dwnld_path;
                    $result = $this->DownloadSubPart($tepPath, $data['section_id'], $value['adm_no']);
                }
                if ($result == true) {
                    GetZipFoderPath($tepPath);
                    echo printCustomMsg('DOWNLOAD', 'Zip created ready to download..', $dwnld_path);
                } else {
                    echo printCustomMsg('PATHRROR', 'File Path not create ', -1);
                }
            }
        } else {
            $data = json_decode($this->input->post('data'), TRUE);
            $dwnld_path = $data['section_id'] . "/" . $data['adm_no'];
            $tepPath = "assets/temp/" . $dwnld_path;
            $result = $this->DownloadSubPart($tepPath, $data['section_id'], $data['adm_no']);
            if ($result == true) {
                GetZipFoderPath($tepPath);
                echo printCustomMsg('DOWNLOAD', 'Zip created ready to download..', $dwnld_path);
            } else {
                echo printCustomMsg('PATHRROR', 'File Path not create ', -1);
            }
        }
    }

    public function DownloadSubPart($tepPath, $section, $adm_no) {
        if (!is_dir($tepPath)) {
            mkdir($tepPath, 0755, true);
        }
        $filePath = "assets/files/reportCards/" . $this->session->userdata('school_code') . "/" . $section . "/" . $adm_no;
        if (is_dir($tepPath)) {
            copy_directory($filePath, $tepPath);
            return true;
        } else {
            return false;
        }
    }

    public function GetPdfOfIdCard($adm_no, $schoolCode) {
//        echo $schoolCode;exit;
        $this->load->model('staff/reportcard_model', 'reportObj');
        $dbName = $this->reportObj->GetStudentDatabaseName($schoolCode);
        $this->load->model('staff/student_model', 'modelobj');
        $idcardinfo = $this->modelobj->idCardDetails(NULL, $adm_no, $dbName);
        try {
            echo $idcardinfo[0]['idcard'];
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
