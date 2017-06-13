<?php

class library_controller extends MY_Controller {

    public function AddBooks() {
        $this->load->view('staff/library/booksentry_view');
    }

    public function IssueBooks() {
        $this->load->view('staff/library/issuebooks_view');
    }

    public function ReturnBooks($admission_no = -1) {
        $this->load->model('staff/library_model', 'modelObj');
        $finedetails = $this->modelObj->GetFineDetail();
        $studentinfo = $this->modelObj->LoadStudentInfo($admission_no);
        $this->load->view('staff/library/returnbooks_view', array("studentBookDetail" => $studentinfo, "finedata" => $finedetails, "adm_no" => $admission_no));
    }

    public function SaveBookDetails() {
        $addArray = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $bookdetail = $this->modelObj->SaveBookDetail($addArray);
        if ($bookdetail != -1) {
            if ($bookdetail == 'EXIST') {
                echo printCustomMsg("SAVEERR", "Book no. already exist.", $bookdetail);
            } else {
                echo printCustomMsg("TRUE", "Book added successfully.", $bookdetail);
            }
        } else {
            echo printCustomMsg("SAVEERR", "Some error occurred.", $bookdetail);
        }
    }

    public function RecentlyAddedBooks() {
        $this->load->model('staff/library_model', 'modelObj');
        $viewbook = $this->modelObj->RecentlyAddedBook();
        try {
            echo json_encode($viewbook);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SearchBookDetails() {
        $search = $this->input->get('search');
        $this->load->model('staff/library_model', 'modelObj');
        $searchbook = $this->modelObj->SearchBookDetail($search);
        try {
            echo json_encode(array("results" => $searchbook));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function GetSearchResults() {
        $searchbook = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $searchdata = $this->modelObj->GetSearchResult($searchbook);
        try {
            echo json_encode($searchdata);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function UpdateBookQuantities() {
        $addquantity = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $update = $this->modelObj->UpdateBookQuantity($addquantity);
        if ($update != -1) {
            echo printCustomMsg("TRUE", "Book updated successfully..", $update);
        } else {
            echo printCustomMsg("SAVEERR", "Some error occurred, please try again.", $update);
        }
    }

    public function LoadBookDetails() {
        $bookno = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $bookdetails = $this->modelObj->LoadBookDetail($bookno);
        try {
            echo json_encode($bookdetails);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function LoadStudentDetails() {
        $admission_no = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $studentdetails = $this->modelObj->LoadStudentDetail($admission_no);
        try {
            echo json_encode($studentdetails);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function IssueBookDetails() {
        $issueArray = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $issuedetail = $this->modelObj->IssueBookDetail($issueArray);
        if ($issuedetail > 0) {
            echo printCustomMsg("TRUE", "Book issue successfully..", $issuedetail);
        } elseif ($issuedetail === 'nobooks') {
            echo printCustomMsg("SAVEERR", "No Books in Library..!!", $issuedetail);
        } else {
            echo printCustomMsg("SAVEERR", "Some error occurred, please try again.", $issuedetail);
        }
    }

    public function RecentIssueBooks() {
        $this->load->model('staff/library_model', 'modelObj');
        $recentissuedetail = $this->modelObj->RecentIssueBook();
        try {
            echo json_encode($recentissuedetail);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function LoadStudentInfos() {
        $admno = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $finedetails = $this->modelObj->GetFineDetail();
        $studentinfo = $this->modelObj->LoadStudentInfo($admno);
        try {
            echo json_encode(array('studentdetail' => $studentinfo, 'finedetail' => $finedetails));
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveChangesBooks() {
        $this->load->model('staff/library_model', 'modelObj');
        $returndata = json_decode($this->input->post('data'), true);
        $returnresult = $this->modelObj->SaveChangesBook($returndata);

        if ($returnresult != -1) {
            echo printCustomMsg("TRUE", "Book return successfully..", $returnresult);
        } else {
            echo printCustomMsg("SAVEERR", "Some error occurred, Please try again.", $returnresult);
        }
    }

    public function RecentlyIssuedBooks() {
        $this->load->model('staff/library_model', 'modelObj');
        $recentlyissuedinfo = $this->modelObj->RecentlyIssuedBook();
        try {
            echo json_encode($recentlyissuedinfo);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function BookFine() {
        $this->load->view('staff/library/finesetting_view');
    }

    public function GetFineDetails() {
        $this->load->model('staff/library_model', 'modelObj');
        $finedetails = $this->modelObj->GetFineDetail();
        try {
            echo json_encode($finedetails);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function SaveFineDetails() {
        $fine = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $finedetails = $this->modelObj->SaveFineDetail($fine);
        if ($finedetails != -1) {
            echo printCustomMsg("TRUE", "Fine Settings Saved..", $finedetails);
        } else {
            echo printCustomMsg("SAVEERR", "Some error occurred, Please try again.", $finedetails);
        }
    }

    public function defaulter_Status($sec_id = NULL) {
        $this->load->model('core/core', 'dbobj');
        $section_list = $this->dbobj->getSectionlist();
        $this->load->view("staff/library/lms_report_view/defaulter_status_view", array('section_id' => $sec_id, "section_list" => $section_list));
    }

    public function total_issued_book($sec_id = NULL) {
        $this->load->model('core/core', 'dbobj');
        $section_list = $this->dbobj->getSectionlist();
        $this->load->view("staff/library/lms_report_view/total_issued_book", array('section_id' => $sec_id, "section_list" => $section_list));
    }

    public function lost_book_report($sec_id = NULL) {
        $this->load->model('core/core', 'dbobj');
        $section_list = $this->dbobj->getSectionlist();
        $this->load->view("staff/library/lms_report_view/lost_book_report", array('section_id' => $sec_id, "section_list" => $section_list));
    }

    public function student_centric_report() {
        $this->load->view("staff/library/lms_report_view/student_centric_report");
    }

    public function book_centric_report() {
        $this->load->view("staff/library/lms_report_view/book_centric_report");
    }

    public function total_fine_collection() {
        $this->load->view("staff/library/lms_report_view/total_fine_collection");
    }

    public function GetBookIssueDetail() {
        $bookId = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $result = $this->modelObj->BookCentricReport($bookId);
        if ($result > 0) {
            echo json_encode($result);
        } else {
            echo json_encode($result);
        }
    }

    public function GetfineDetail() {
        $data = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $result['totalfinelist'] = $this->modelObj->TotalFine($data);
        $fineSummary = $this->modelObj->monthViseFineSummary();
        $result['monthvisesummary'] = $fineSummary;
        if (empty($result)) {
            echo json_encode($result);
        } else {
            echo json_encode($result);
        }
    }

    public function GetStudentDetail() {
        $admno = json_decode($this->input->post('data'), true);
        $this->load->model('staff/library_model', 'modelObj');
        $result = $this->modelObj->StudentCentricReport($admno);
        if (empty($result)) {
            echo "no data";
        } else {
            echo json_encode($result);
        }
    }

}
