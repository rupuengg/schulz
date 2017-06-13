<?php

class ccegrade_model extends CI_Model {

    public function GetCCEGradeDetails($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $dbObj->select('cce_grades_di.di,cce_grade_setting.grade,cce_grades_di.term,cce_grades_di.entry_by,cce_grades_di.timestamp,cce_list.caption_show');
        $dbObj->from('cce_list');
        $dbObj->join('cce_grades_di', 'cce_list.id=cce_grades_di.cce_id');
        $dbObj->join('cce_grade_setting', 'cce_grades_di.grade=cce_grade_setting.id');
        $dbObj->where('cce_grades_di.adm_no', $dataObj['adm_no']);
        $grades = $dbObj->get()->result_array();
        $arrFinalCCE = array();
        $i = 0;
        if (!empty($grades)) {
            foreach ($grades as $row) {
                $arrCCE = array();
                $staff_id = $row['entry_by'];
                $staff_detail = $this->coreObj->GetStaffName($staff_id);
                $arrCCE['timestamp'] = $row['timestamp'];
                $arrCCE['type'] = 'CCEGRADE';
                $arrCCE['data'] = array('di' => $row['di'], 'grade' => $row['grade'], 'term' => $row['term'], 'staff_name' => $staff_detail['name'], 'cce_name' => $row['caption_show'], 'staff_id' => $staff_detail['id']);
                $arrFinalCCE[$i] = $arrCCE;
                $i++;
            }
            return $arrFinalCCE;
        } else {
            return 0;
        }
    }

    public function RightCCEGrade($dataObj, $term) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('parent/parent_core', 'coreObj');
        $cce_list = $this->coreObj->GetAllCCEName($dataObj['class']);
        $arrRightFinalCCE = array();
        $i = 0;
        if (!empty($cce_list)) {
            foreach ($cce_list as $row) {
                $arrRightCCE = array();
                $dbObj->select('a.di,b.grade,a.term,a.entry_by,a.timestamp');
                $dbObj->from('cce_grades_di as a');
                $dbObj->join('cce_grade_setting as b', 'a.grade=b.id');
                $dbObj->where('a.cce_id', $row['id']);
                $dbObj->where('a.adm_no', $dataObj['adm_no']);
                $dbObj->where('a.term', $term);
                $grade = $dbObj->get()->result_array();
                if (!empty($grade)) {
                    $staff_id = $grade[0]['entry_by'];
                    $staff_name = $this->coreObj->GetStaffName($staff_id);
                    $arrRightCCE['timestamp'] = $grade[0]['timestamp'];
                    $arrRightCCE['type'] = 'CCEGRADE';
                    $arrRightCCE['data'] = array('staff_name' => $staff_name['name'], 'staff_id' => $staff_name['id'], 'cce_name' => $row['caption_show'], 'di' => $grade[0]['di'], 'term' => $grade[0]['term'], 'grade' => $grade[0]['grade'], 'color' => 'LIME');
                } else {
                    $arrRightCCE['timestamp'] = 'Not Declare Yet..';
                    $arrRightCCE['type'] = 'CCEGRADE';
                    $arrRightCCE['data'] = array('staff_name' => '', 'staff_id' => '', 'cce_name' => $row['caption_show'], 'di' => 'Not Declare Yet..', 'term' => 'Not Declare Yet..', 'grade' => '', 'color' => 'WHITE');
                }
                $arrRightFinalCCE[$i] = $arrRightCCE;
                $i++;
            }
            return $arrRightFinalCCE;
        } else {
            return 0;
        }
    }

}
