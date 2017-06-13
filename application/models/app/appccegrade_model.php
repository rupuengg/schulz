<?php

class appccegrade_model extends CI_Model {

    public function GetCCEGradeDetails($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $dbObj->select('cce_grades_di.di,cce_grade_setting.grade,cce_grades_di.term,cce_grades_di.entry_by,cce_grades_di.timestamp,cce_list.caption_show');
        $dbObj->from('cce_list');
        $dbObj->join('cce_grades_di', 'cce_list.id=cce_grades_di.cce_id');
        $dbObj->join('cce_grade_setting', 'cce_grades_di.grade=cce_grade_setting.id');
        $dbObj->where('cce_grades_di.adm_no', $dataObj['adm_no']);
        $dbObj->order_by('cce_grades_di.timestamp','desc');
        $dbObj->limit(10);
        $grades = $dbObj->get()->result_array();
        $arrFinalCCE = array();
        $i = 0;
        if (!empty($grades)) {
            foreach ($grades as $row) {
                $staff_detail = $this->coreObj->GetStaffName($row['entry_by'], $dbObj);
                $arrCCE = array('type' => 'CCEGRADE', 'timestamp' => $row['timestamp'], 'di' => $row['di'], 'grade' => $row['caption_show'] . ':TERM' . $row['term'] . '-' . $row['grade'], 'staff_name' => $staff_detail['name'], 'staff_id' => $staff_detail['id'], 'staff_pic' => base_url() . 'index.php/app/getstaffphoto/' . $staff_detail['id'] . '/THUMB');
                $arrFinalCCE[$i] = $arrCCE;
                $i++;
            }
            return $arrFinalCCE;
        } else {
            return 0;
        }
    }

    public function RightCCEGrade($dataObj, $term) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $cce_list = $this->coreObj->GetAllCCEName($dataObj['class'], $dbObj);
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
                    $staff_name = $this->coreObj->GetStaffName($grade[0]['entry_by'], $dbObj);
                    $arrRightCCE = array('timestamp' => $grade[0]['timestamp'], 'staff_pic' => base_url() . 'index.php/app/getstaffphoto/' . $staff_name['id'] . '/THUMB', 'staff_name' => $staff_name['name'], 'staff_id' => $staff_name['id'], 'cce_name' => $row['caption_show'] . '-' . $grade[0]['grade'], 'di' => $grade[0]['di'], 'grade' => $grade[0]['grade'], 'color' => 'LIME');
                } else {
                    $arrRightCCE = array('cce_name' => $row['caption_show'], 'color' => 'WHITE');
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
