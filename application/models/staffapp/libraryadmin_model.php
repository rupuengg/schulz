<?php

class libraryadmin_model extends CI_Model {

    public function LibIssueData($dbObj) {
        $dbObj->select('book_id,adm_no,issue_date');
        $dbObj->limit(10);
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->group_by('adm_no');
        $issued = $dbObj->get_where("lms_book_issue_detail", array('status' => 'ISSUED'))->result_array();
        $final_arr = array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        for ($i = 0; $i < count($issued); $i++) {
            $stu_det = $this->coreObj->GetStudentDetail($issued[$i]['adm_no'], $dbObj);
            $book_name = $this->GetBookName($issued[$i]['book_id'], $dbObj);
            $dbObj->select('count(id) as count');
            $count = $dbObj->get_where("lms_book_issue_detail", array('adm_no' => $issued[$i]['adm_no'], 'status' => 'ISSUED'))->row_array();
            $count_tot = $count['count'] - 1;
            $issued_date = date('jS M Y', strtotime($issued[$i]['issue_date']));
            if ($count_tot == 0) {
                $count_finl = '';
                $final_arr[] = array('stu_name' => $stu_det['student_name'] . '(' . $stu_det['class'] . ')', 'book_name' => $book_name['book_name'], 'book_note' => $count_finl, 'issued_date' => $issued_date);
            } else {
                $count_finl = $count_tot;
                $final_arr[] = array('stu_name' => $stu_det['student_name'] . '(' . $stu_det['class'] . ')', 'book_name' => $book_name['book_name'], 'book_note' => '*Read ' . $count_finl . ' more books', 'issued_date' => $issued_date);
            }
        }
        return $final_arr;
    }

    public function GetBookName($book_id, $dbObj) {
        $dbObj->select('book_name');
        $dbObj->where('id', $book_id);
        $book_name = $dbObj->get("lms_book_details")->row_array();
        return $book_name;
    }

    public function LibDefaulterData($dbObj) {
        $curr_date = date('Y-m-d');
        $dbObj->select("book_id,adm_no,due_date");
        $dbObj->limit(10);
        $dbObj->order_by('timestamp', 'desc');
        $dbObj->group_by('adm_no');
        $defaulter = $dbObj->get_where('lms_book_issue_detail', array('status' => 'ISSUED', 'due_date <' => $curr_date))->result_array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $final_arr = array();        
        for ($i = 0; $i < count($defaulter); $i++) {
            $stu_det = $this->coreObj->GetStudentDetail($defaulter[$i]['adm_no'], $dbObj);
            $book_name = $this->GetBookName($defaulter[$i]['book_id'], $dbObj);
            $dbObj->select('count(id) as count');
            $count = $dbObj->get_where("lms_book_issue_detail", array('adm_no' => $defaulter[$i]['adm_no'], 'status' => 'ISSUED'))->row_array();
            $count_tot = $count['count'] - 1;
            $default_date = date('jS M Y', strtotime($defaulter[$i]['due_date']));
            if ($count_tot == 0) {
                $count_finl = '';
                $final_arr[] = array('stu_name' => $stu_det['student_name'] . '(' . $stu_det['class'] . ')', 'book_name' => $book_name['book_name'], 'book_note' => $count_finl, 'last_date' => $default_date);
            } else {
                $count_finl = $count_tot;
                $final_arr[] = array('stu_name' => $stu_det['student_name'] . '(' . $stu_det['class'] . ')', 'book_name' => $book_name['book_name'], 'book_note' => '*Read ' . $count_finl . ' more books', 'last_date' => $default_date);
            }
        }       
        return $final_arr;
    }

    public function LibFineData($dbObj) {
        $dbObj->select("book_id,adm_no,fine_ammount,other_charges");
        $dbObj->limit(10);
        $dbObj->order_by('timestamp', 'desc');
        $fine = $dbObj->get_where('lms_book_issue_detail', array('status !=' => 'ISSUED'))->result_array();
        $final_arr = array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        for ($i = 0; $i < count($fine); $i++) {
            $total_fine = 0;
            $stu_det = $this->coreObj->GetStudentDetail($fine[$i]['adm_no'], $dbObj);
            $book_name = $this->GetBookName($fine[$i]['book_id'], $dbObj);
            if ($fine[$i]['fine_ammount'] != 0 || $fine[$i]['other_charges'] != 0) {
                $total_fine = $fine[$i]['fine_ammount'] + $fine[$i]['other_charges'];
                $final_arr[] = array('stu_name' => $stu_det['student_name'], 'book_name' => $book_name['book_name'], 'fine' => $total_fine.' Rupees');
            }
        }
        return $final_arr;
    }
    
    public function MainLibData($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $fine = $this->LibFineData($dbObj);
        $defaulter = $this->LibDefaulterData($dbObj);
        $issued = $this->LibIssueData($dbObj);
        $bookcount = $this->getTotalBooksList($dataObj);
        $final_arr = array('libBookCount'=>$bookcount ,'issued'=>$issued,'defaulters'=>$defaulter,'fine_collctd'=>$fine);
        return $final_arr;
    }
    
    public function getTotalBooksList($dataObj) {
       $dbObj = $this->load->database($dataObj['database'], TRUE);
       $dbObj->select('id');
       $totalBook = $dbObj->get('lms_book_details')->result_array();
       $dbObj->select('id');
       $totalIssueBk = $dbObj->get_where("lms_book_issue_detail", array('status' => 'ISSUED'))->result_array();
       $dbObj->select('id');
       $totalLostBk = $dbObj->get_where("lms_book_issue_detail", array('status' => 'LOST'))->result_array();
       $libryTotalLeftBk = count($totalBook) - count($totalIssueBk) - count($totalLostBk);
       return array('totalBook'=>count($totalBook),'totalIssueBk'=>count($totalIssueBk),'libryTotalLeftBk'=>$libryTotalLeftBk,'totalLostBk'=>count($totalLostBk));
    }

}