<?php

class appsummary_model extends CI_Model {

    public function GetSummaryDetails($dataObj) {
        $this->load->model('app/appacademics_model', 'academicObj');
        $arrMarks = $this->academicObj->LoadStudentMarks($dataObj);
        $this->load->model('app/appattendance_model', 'attObj');
        $arrAtt = $this->attObj->GetAbsentData($dataObj);
        $this->load->model('app/appcard_model', 'cardObj');
        $arrCard = $this->cardObj->GetCardDetails($dataObj);
        $arrFinal = array_merge((array) $arrCard, (array) $arrMarks, (array) $arrAtt);
        return $arrFinal;
    }

    public function GetStuMarks($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $adm_no = $dataObj['adm_no'];
        $this->load->model('app/appparent_core', 'coreObj');
        $subjectList = $this->coreObj->GetSubjectListFromSection($dataObj['section_id'], $dbObj);
        $arrExamner = array();
        $arrFinal = array();
        for ($j = 0; $j < count($subjectList); $j++) {
            $arrTempmrk = array();
            $i = 0;
            $sub_id = $subjectList[$j]['sub_id'];
            $query = "SELECT a.id,a.exam_name,sum(c.marks),c.entry_by FROM exam_settings as a, exam_parts_details as b, exam_marks_details as c WHERE c. adm_no=$adm_no AND a.subject_id=$sub_id AND c.exam_part_id=b.id AND a.id=b.exam_id group by a.id ";
            $output = $dbObj->query($query)->result_array();
            if (!empty($output)) {
                $staff_deatil = $this->coreObj->GetStaffName($output[0]['entry_by'], $dbObj);
                foreach ($output as $val) {
                    $arrTempmrk[$i] = $val['exam_name'];
                    $i++;
                }
                $string = implode(',', $arrTempmrk);
                $subjectList[$j]['exam'] = $string;
                $subjectList[$j]['staff_name'] = $staff_deatil['name'];
                $subjectList[$j]['staff_id'] = $staff_deatil['id'];
                $subjectList[$j]['staff_pic'] = $staff_deatil['profilePic'];
            } else {
                $subjectList[$j]['exam'] = '';
                $subjectList[$j]['staff_name'] = '';
                $subjectList[$j]['staff_id'] = '';
                $subjectList[$j]['staff_pic'] = '';
            }
        }
        $arrFinal['subject'] = $subjectList;
        $arrFinal['studentName'] = ucfirst(strtolower($dataObj['firstname'])) . ' ' . ucfirst(strtolower($dataObj['lastname'])) . " 's Subjects ";
        return $arrFinal;
    }

}
