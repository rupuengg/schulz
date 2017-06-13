<?php

class library_model extends CI_Model {

    public function SaveBookDetail($addArray) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if (!isset($addArray['id'])) {
            $book = $dbObj->get_where('lms_book_details', array("book_no" => $addArray['book_no']))->result_array();
            if (!empty($book)) {
                return 'EXIST';
            } else {
                $data = array("book_no" => $addArray['book_no'], "book_name" => $addArray['book_name'], "author_name" => $addArray['author_name'], "publisher" => $addArray['publisher'], "category" => $addArray['category'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
                $result = $dbObj->insert('lms_book_details', $data);
                $book_id = $dbObj->insert_id();
                if ($book_id > 0) {
                    $dataquantity = array("book_id" => $book_id, "quantity" => $addArray['quantity'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
                    $resultquantity = $dbObj->insert('lms_book_quantity_detail', $dataquantity);
                    $lastinsert_id = $dbObj->insert_id();
                    if ($lastinsert_id > 0) {
                        return $lastinsert_id;
                    } else {
                        return -1;
                    }
                } else {
                    return -1;
                }
            }
        } else {
            $dbObj->delete('lms_book_details', array('id' => $addArray['id']));
            $data = array("book_no" => $addArray['book_no'], "book_name" => $addArray['book_name'], "author_name" => $addArray['author_name'], "publisher" => $addArray['publisher'], "category" => $addArray['category'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
            $result = $dbObj->insert('lms_book_details', $data);
            $book_id = $dbObj->insert_id();
            if ($book_id > 0) {
                $dataquantity = array("book_id" => $book_id, "quantity" => $addArray['quantity'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
                $resultquantity = $dbObj->insert('lms_book_quantity_detail', $dataquantity);
                $lastinsert_id = $dbObj->insert_id();
                if ($lastinsert_id > 0) {
                    return $lastinsert_id;
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        }
    }

    public function RecentlyAddedBook() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,book_no,book_name,author_name,publisher,category');
        $dbObj->limit('10');
        $dbObj->order_by('timestamp', 'desc');
        $bookdetail = $dbObj->get('lms_book_details')->result_array();
        for ($i = 0; $i < count($bookdetail); $i++) {
            $dbObj->select('sum(quantity) as quantity');
            $quantity = $dbObj->get_where(' lms_book_quantity_detail', array('book_id' => $bookdetail[$i]['id']))->row_array();
            $bookdetail[$i]['quantity'] = $quantity['quantity'];
        }
        if (!empty($bookdetail)) {
            return $bookdetail;
        } else {
            return -1;
        }
    }

    public function SearchBookDetail($searchbook) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,a.book_name,a.book_no,a.author_name,a.publisher,a.category');
        $dbObj->from('lms_book_details as a');
        $dbObj->like('book_name', $searchbook);
        $dbObj->or_like('book_no', $searchbook);
        $searchbookresult = $dbObj->get()->result_array();
        for ($i = 0; $i < count($searchbookresult); $i++) {
            $dbObj->select('sum(quantity) as quantity');
            $quantity = $dbObj->get_where(' lms_book_quantity_detail', array('book_id' => $searchbookresult[$i]['id']))->row_array();
            if (!empty($quantity)) {
                $searchbookresult[$i]['quantity'] = $quantity['quantity'];
            }
        } if (!empty($searchbookresult)) {
            return $searchbookresult;
        } else {
            return -1;
        }
    }

    public function GetSearchResult($book_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $bookId = $this->GetBookId($book_no, $dbObj);
        $dbObj->select("id,quantity,DATE_FORMAT(`timestamp`, '%d-%m-%Y') as date", FALSE);
        $searchbookresult = $dbObj->get_where('lms_book_quantity_detail', array('book_id' => $bookId))->result_array();

        if (!empty($searchbookresult)) {
            return $searchbookresult;
        } else {
            return -1;
        }
    }

    public function UpdateBookQuantity($addquantity) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array("book_id" => $addquantity['book_id'], "quantity" => $addquantity['quantity'], "reason" => $addquantity['reason'], "update_date" => $addquantity['update_date'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
        $quantity = $dbObj->insert('lms_book_quantity_detail', $data);
        $lastinsert_id = $dbObj->insert_id();
        if ($lastinsert_id > 0) {
            return $lastinsert_id;
        } else {
            return -1;
        }
    }

    public function LoadBookDetail($bookno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('book_no,book_name,author_name,publisher');
        $book_result = $dbObj->get_where('lms_book_details', array('book_no' => $bookno))->row_array();
        if (!empty($book_result)) {
            return $book_result;
        } else {
            return -1;
        }
    }

    public function LoadstudentDetail($admission_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.adm_no,a.firstname,a.lastname,b.standard,b.section');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $admission_no);
        $studentresult = $dbObj->get()->row_array();
        if (!empty($studentresult)) {
            return $studentresult;
        } else {
            return -1;
        }
    }

    public function SearchStudentDetail() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.book_id,a.adm_no,b.firstname,b.lastname');
        $dbObj->from('lms_book_issue_detail as a');
        $dbObj->join('biodata as b', 'a.adm_no=b.adm_no');
        $dbObj->where('a.adm_no', $admission_no);
        $dbObj->like('adm_no', $searchstudentdata);
        $searchstudentresult = $dbObj->get()->result_array();
        if (!empty($searchstudentresult)) {
            return $searchstudentresult;
        } else {
            return -1;
        }
    }

    public function IssueBookDetail($issueArray) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('due_days');
        $duedays = $dbObj->get('lms_fine_settings')->row_array();
        $dueDays = $duedays['due_days'];
        $issue_date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime("+$dueDays days"));
        $book_id = $this->GetBookId($issueArray['bookid'], $dbObj);
        $dbObj->select('quantity');
        $totalBook = $dbObj->get_where('lms_book_quantity_detail',array('book_id'=>$book_id))->result_array();
        $sum = 0;
        foreach ($totalBook as $value) {
              $sum = $value['quantity'] + $sum ;
         }
         $totalBkQaunty = $sum;
        $dbObj->select('book_id');
        $totalIssueBook = $dbObj->get_where('lms_book_issue_detail',array('book_id'=>$book_id))->result_array();
        if(count($totalIssueBook)<= $totalBkQaunty){
        $data = array("book_id" => $book_id, "adm_no" => $issueArray['studentadm_no'], "issue_date" => $issue_date, "due_date" => $due_date, "status" => 'ISSUED', "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
        $dbObj->insert('lms_book_issue_detail', $data);
        $last_insert_id = $dbObj->insert_id();
        if ($last_insert_id > 0) {
            return $last_insert_id;
        } else {
            return -1;
        }
        }else{
            return 'nobooks';
        }
    }

    public function RecentIssueBook($admission_no = '') {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("a.id,a.book_no,a.book_name,b.issue_date,b.due_date,c.adm_no,c.firstname,c.lastname", FALSE);
        $dbObj->from('lms_book_details as a');
        $dbObj->where('b.status', 'ISSUED');
        $dbObj->join('lms_book_issue_detail as b', 'a.id=b.book_id');
        $dbObj->join('biodata as c', 'b.adm_no=c.adm_no');
        $dbObj->order_by('b.timestamp', 'desc');
        $dbObj->limit('10');
        $result = $dbObj->get()->result_array();
        
        for($i=0; $i < count($result);$i++){
            $result[$i]['issue_date'] = ChangeMydateFormat($result[$i]['issue_date']);
            $result[$i]['due_date'] = ChangeMydateFormat($result[$i]['due_date']);
        }
       
        return $result;
    }

    public function LoadStudentInfo($admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('fine_per_day');
        $dueday = $dbObj->get('lms_fine_settings')->row_array();
        $dbObj->select('a.id,a.book_id,a.issue_date,a.due_date,a.status,b.book_name');
        $dbObj->from('lms_book_issue_detail as a');
        $dbObj->join('lms_book_details as b', 'a.book_id=b.id');
        $dbObj->where('a.status', 'ISSUED');
        $dbObj->where('a.adm_no', $admno);
        $studentdata = $dbObj->get()->result_array();
        for ($i = 0; $i < count($studentdata); $i++) {
            $currentdate = date('Y-m-d');
            if ($currentdate > $studentdata[$i]['due_date']) {
                $curdate = strtotime($currentdate);
                $duedate = strtotime($studentdata[$i]['due_date']);
                $daydifference = ($curdate - $duedate) / 86400;
                $fineamount = $daydifference * $dueday['fine_per_day'];
                $studentdata[$i]['fine_amount'] = $fineamount;
            } else {
                $studentdata[$i]['fine_amount'] = 0;
            }
        }
        if (!empty($studentdata)) {
            return $studentdata;
        } else {
            return -1;
        }
    }

    public function SaveChangesBook($returnbookArray) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $returndate = date('Y-m-d');
        $dbObj->delete('lms_book_issue_detail', array('id' => $returnbookArray['returndata']['id']));
        if ($returnbookArray['returndata']['returntype'] == 1) {
            $data = array("other_charges" => $returnbookArray['returndata']['extraamount'], "reason" => $returnbookArray['returndata']['reason'], "book_id" => $returnbookArray['returndata']['book_id'], "adm_no" => $returnbookArray['adm_no'], "issue_date" => $returnbookArray['returndata']['issue_date'], "return_date" => $returndate, "due_date" => $returnbookArray['returndata']['due_date'], "status" => 'LOST', "fine_ammount" => $returnbookArray['returndata']['fine_amount'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
            $result = $dbObj->insert('lms_book_issue_detail', $data);
            $quantitydata = array("book_id" => $returnbookArray['returndata']['book_id'], "quantity" => '-1', "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
            $result = $dbObj->insert('lms_book_quantity_detail', $quantitydata);
            $lastinsert_id = $dbObj->insert_id();
            if ($lastinsert_id > 0) {
                return $lastinsert_id;
            } else {
                return -1;
            }
        } else {
            $returndata = array("other_charges" => $returnbookArray['returndata']['extraamount'], "reason" => $returnbookArray['returndata']['reason'], "book_id" => $returnbookArray['returndata']['book_id'], "adm_no" => $returnbookArray['adm_no'], "issue_date" => $returnbookArray['returndata']['issue_date'], "return_date" => $returndate, "due_date" => $returnbookArray['returndata']['due_date'], "status" => 'RETURN', "fine_ammount" => $returnbookArray['returndata']['fine_amount'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
            $result = $dbObj->insert('lms_book_issue_detail', $returndata);
            $last_insert_id = $dbObj->insert_id();
            if ($last_insert_id > 0) {
                return $last_insert_id;
            } else {
                return -1;
            }
        }
    }

    public function RecentlyIssuedBook() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select("book_id,adm_no,issue_date,return_date", FALSE);
        $dbObj->where('status', 'RETURN');
        $dbObj->or_where('status', 'LOST');
        $dbObj->from('lms_book_issue_detail as a');
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->limit('10');
        $recentReturnBook = $dbObj->get()->result_array();

        for ($i = 0; $i < count($recentReturnBook); $i++) {
            $bookDeatil = $this->GetBookDeatil($recentReturnBook[$i]['book_id'], $dbObj);
            $studentDeatil = $this->GetStudentDeatil($recentReturnBook[$i]['adm_no'], $dbObj);
            $recentReturnBook[$i]['name'] = $studentDeatil['adm_no'] . '.' . $studentDeatil['firstname'] . ' ' . $studentDeatil['lastname'];
            $recentReturnBook[$i]['book_name'] = $bookDeatil['book_name'];
            $recentReturnBook[$i]['issue_date'] = ChangeMydateFormat($recentReturnBook[$i]['issue_date']);
            $recentReturnBook[$i]['return_date'] = ChangeMydateFormat($recentReturnBook[$i]['return_date']);
        }
        
        //print_r($recentReturnBook); exit;
        return $recentReturnBook;
    }

    public function GetFineDetail() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('due_days,fine_per_day');
        $dbObj->from('lms_fine_settings');
//        $dbObj->where('fine_per_day', $fine);
        $finedata = $dbObj->get()->row_array();
        if (!empty($finedata)) {
            return $finedata;
        } else {
            return -1;
        }
    }

    public function SaveFineDetail($fine) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->truncate('lms_fine_settings');
        $data = array("due_days" => $fine['due_days'], "fine_per_day" => $fine['fine_per_day'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
        $result = $dbObj->insert('lms_fine_settings', $data);
        $lastinsert_id = $dbObj->insert_id();
        if ($lastinsert_id > 0) {
            return $lastinsert_id;
        } else {
            return -1;
        }
    }

    public function StudentCentricReport($admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.issue_date,a.due_date,a.status,a.fine_ammount,b.book_name');
        $dbObj->from('lms_book_issue_detail as a');
        $dbObj->join('lms_book_details as b', 'a.book_id=b.id');
        $dbObj->where('a.adm_no', $admno['admno']);
        $resultbook = $dbObj->get()->result_array();
        //print_r($resultbook); exit;
        if (!empty($resultbook)) {
             for ($i = 0; $i < count($resultbook); $i++) {
                $resultbook[$i]['issue_date'] = ChangeMydateFormat($resultbook[$i]['issue_date']);
                $resultbook[$i]['due_date'] = ChangeMydateFormat($resultbook[$i]['due_date']);
               
             }
            $result['bookdetail'] = $resultbook;
            $studentdetail = $this->student_detail($admno['admno']);
            $result['studentdetail'] = $studentdetail;
            return $result;
        } else {
            return -1;
        }
    }

    public function BookCentricReport($bookname) {
         $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,a.book_name,a.author_name');
        $dbObj->from('lms_book_details as a');
        $dbObj->join('lms_book_quantity_detail as b', 'a.id=b.book_id');
        $dbObj->where('a.book_name', $bookname['bookid']);
        $dbObj->or_where('a.book_no', $bookname['bookid']);
        $result = $dbObj->get()->row_array();
        if (!empty($result)) {
            $countlostbook = $this->CountStatus($result['id']);
            $countissuedbook = $this->Countissuedbook($result['id']);
            $studentlist = $this->studentdetail($result['id']);
            $bookquantity = $this->getBookQuantity($result['id']);
            $result['countlostbook'] = $countlostbook;
            $result['counttotalbook'] = $bookquantity;
            $result['countissuedbook'] = $countissuedbook;
            $result['studentlist'] = $studentlist;
            return $result;
        } else {
            return -1;
        }
    }

    public function TotalFine($data) {
        $newFromDate = date("Y-m-d", strtotime($data['from']));
        $newToDate = date("Y-m-d", strtotime($data['to']));
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('fine_ammount,other_charges,book_id,adm_no');
        $dbObj->from('lms_book_issue_detail');
        $where = "`return_date` >= '" . $newFromDate . "' AND `return_date` <= '" . $newToDate . "' AND ( `fine_ammount` > 0  OR  `other_charges` > 0)AND ( `status` = 'LOST' OR `status` = 'RETURN')";
        $dbObj->where($where);
        $resultfirst1 = $dbObj->get()->result_array();
        if (!empty($resultfirst1)) {
            for ($i = 0; $i < count($resultfirst1); $i++) {
                $bookDeatil = $this->GetBookDeatil($resultfirst1[$i]['book_id'], $dbObj);
                $studentDeatil = $this->GetStudentDeatil($resultfirst1[$i]['adm_no'], $dbObj);
                $resultfirst1[$i]['studentName'] = $studentDeatil['adm_no'] . '.' . $studentDeatil['firstname'] . ' ' . $studentDeatil['lastname'];
                $resultfirst1[$i]['bookName'] = $bookDeatil['book_name'];
            }
            $result['detail'] = $resultfirst1;
            $result['totalfine'] = $this->getTotalFine($newFromDate, $newToDate);
            return $result;
        } else {

            return -1;
        }
    }

    public function CountStatus($bookid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('status');
        $dbObj->from('lms_book_issue_detail');
        $dbObj->where('status', 'LOST');
        $dbObj->where('book_id', $bookid);
        return $dbObj->count_all_results();
    }

    public function Countissuedbook($bookid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('status');
        $dbObj->from('lms_book_issue_detail');
        $dbObj->where('status', 'ISSUED');
        $dbObj->where('book_id', $bookid);
        return $dbObj->count_all_results();
    }

    public function studentdetail($bookid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.issue_date,a.due_date,a.status,a.adm_no,b.firstname,b.lastname');
        $dbObj->from('lms_book_issue_detail as a');
        $dbObj->join('biodata as b', 'a.adm_no=b.adm_no');
        $dbObj->where('a.book_id', $bookid);
        $result = $dbObj->get()->result_array();
         for ($i = 0; $i < count($result); $i++) {
                $result[$i]['issue_date'] = ChangeMydateFormat($result[$i]['issue_date']);
                $result[$i]['due_date'] = ChangeMydateFormat($result[$i]['due_date']);
               
             }
        return $result;
    }

    public function student_detail($admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.adm_no,b.standard,b.section');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('a.adm_no', $admno);
        $result = $dbObj->get()->row_array();

        return $result;
    }

    public function getTotalFine($from, $to) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $where = "`return_date` >= '" . $from . "' AND `return_date` <= '" . $to . "' AND ( `fine_ammount` > 0  OR  `other_charges` > 0) AND (`status` = 'LOST' OR `status` = 'RETURN')";
        $dbObj->select('sum(fine_ammount+other_charges)as fine');
        $dbObj->where($where);
        $result = $dbObj->get('lms_book_issue_detail')->row_array();
        return $result;
    }

    public function getBookQuantity($book_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select_sum('quantity');
        $dbObj->where('book_id', $book_id);
        $value = $dbObj->get('lms_book_quantity_detail')->row_array();
        return $value;
    }

    public function monthViseFineSummary() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $term = $this->coreObj->GetTermDate();
        $d1 = $term[0]['date_from'];
        $d2 = $term[1]['date_to'];
        $t1 = strtotime($d1);
        $t2 = strtotime($d2);
        $m1 = date("m", $t1);
        $y1 = date("Y", $t1);
        $m2 = date("m", $t2);
        $y2 = date("Y", $t2);
        $mon1 = $m1;
        $y1 = $y1;
        for ($i = 0; $i < 12; $i++) {
            dx:
            if ($mon1 < 13) {
                $where = "month(return_date) = $mon1 AND year(return_date) = $y1 AND ( `fine_ammount` > 0  OR  `other_charges` > 0) AND (`status` = 'LOST' OR `status` = 'RETURN' )";
                $dbObj->select('sum(fine_ammount+other_charges)as finesummary');
                $dbObj->where($where);
                $result[$i] = $dbObj->get('lms_book_issue_detail')->row_array();
                $mon_name = date("F", strtotime("2000-$mon1-01"));
                $result[$i]['month'] = $mon_name;
                $result[$i]['year'] = $y1;
                $mon1 = $mon1 + 1;
            } else {
                $mon1 = 1;
                $y1 = $y1 + 1;
                goto dx;
            }
        }
        return $result;
    }

    public function GetBookId($book_no, $dbObj) {
        $dbObj->select('id');
        $book_id = $dbObj->get_where('lms_book_details', array('book_no' => $book_no))->row_array();
        return $book_id['id'];
    }

    public function GetBookDeatil($bookId, $dbObj) {
        $bookDeatil = $dbObj->get_where('lms_book_details', array('id' => $bookId))->row_array();
        return $bookDeatil;
    }

    public function GetStudentDeatil($adm_no, $dbObj) {
        $studentDeatil = $dbObj->get_where('biodata', array('adm_no' => $adm_no))->row_array();
        return $studentDeatil;
    }

}
