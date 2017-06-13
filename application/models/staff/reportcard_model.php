<?php

//
error_reporting(0);
//ini_set('display_errors', 1);

class reportcard_model extends CI_Model {

    public function __construct() {
        $this->load->library('studentclass');
    }

    public function GetstandardSection($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('standard,section');
        $result = $dbObj->get_where("section_list", array('id' => $data))->row_array();
        return $result;
    }

    public function GetTermWiseReport($dataObj, $subjectList, $dbObj, $scndry = NULL) {
        $term = $dbObj->get('session_term_setting')->result_array();
        foreach ($term as $key => $row) {
            $examList = $this->GetExamNameListByClass($dataObj['section_id'], $dbObj, $subjectList);
            $termSubjectMarks = $this->GetTermSubjectMarksData($dataObj, $subjectList, $dbObj, $scndry);
            $finalTermArr[] = array('examList' => $examList, 'term' => $row['item'], 'marksData' => $termSubjectMarks);
        }
        return $finalTermArr;
    }

    public function GetExamNameListByClass($sectionId, $dbObj, $subjectList) {
        $c = 0;
        $dbObj->select('standard');
        $class = $dbObj->get_where('section_list', array('id' => $sectionId))->row_array();
        $dbObj->select('exam_name');
        $examList = $dbObj->get_where('exam_master_list', array('class' => $class['standard']))->result_array();
        foreach ($subjectList as $subKey => $subValue) {
            $tempArr = array();
            $dbObj->select('id as exam_id');
            $examIdList = $dbObj->get_where('exam_settings', array('subject_id' => $subValue['subject_id'], 'section_id' => $sectionId))->result_array();

            foreach ($examIdList as $exKey => $exVal) {
                $partDetails = array();
                $dbObj->select('id,part_name');
                $partDetails = $dbObj->get_where('exam_parts_details', array('exam_id' => $exVal['exam_id']))->result_array();
                if (isset($examList[$c])) {
                    $examList[$c]['part'] = $partDetails;
                    $c++;
                }
            }
        }
        return $examList;
    }

    public function GetTermSubjectMarksData($dataObj, $subjectList, $dbObj, $scndry) {
        $subjectMarksArr = array();
        foreach ($subjectList as $subKey => $subValue) {
            $tempArr = array();
            $dbObj->select('id as exam_id');
            $examIdList = $dbObj->get_where('exam_settings', array('subject_id' => $subValue['subject_id'], 'section_id' => $dataObj['section_id']))->result_array();

            foreach ($examIdList as $exKey => $exVal) {
                $dbObj->select('id as pid,part_name as pname,max_marks');
                $partDetails = $dbObj->get_where('exam_parts_details', array('exam_id' => $exVal['exam_id']))->result_array();
                if (!empty($partDetails)) {
                    $marks = $this->GetMarksByPartId($dataObj['adm_no'], $partDetails, $dbObj, $scndry);
                } else {
                    $marks = '-';
                }
                if ($scndry == NULL) {
                    $tempArr[] = $marks;
                } else {
                    if (!empty($marks)) {
                        foreach ($marks as $value => $key) {
                            $tempArr[] = $key;
                        }
                    }
                }
            }
            $subjectMarksArr[] = $tempArr;
        }
        return $subjectMarksArr;
    }

    public function GetMarksByPartId($adm_no, $partExam, $dbObj, $scndry) {
        $sum = 0;
        foreach ($partExam as $val) {
            $dbObj->select('marks');
            $marks = $dbObj->get_where('exam_marks_details', array('adm_no' => $adm_no, 'exam_part_id' => $val['pid']))->row_array();
            if (!empty($marks)) {
                $sum = $sum + $marks['marks'];
                $result[$val['pname']] = $marks['marks'];
            } else {
                $result[] = array($val['pname'] => '-');
            }
        }
//        $result['sum'] = $sum;
        if ($scndry == NULL) {
            return $sum;
        } else {
            return $result;
        }
    }

    public function GetCceGardeData($dataObj, $dbObj) {

        $ccePart = array('PART I ', 'PART II ', 'PART III ');
        $dbObj->select('standard');
        $class = $dbObj->get_where('section_list', array('id' => $dataObj['section_id']))->row_array();
        foreach ($ccePart as $cceKey => $cceVal) {
            $dbObj->distinct();
            $dbObj->select('id,cce_name,caption_show');
            $dbObj->like('cce_name', $cceVal, 'after');
            $cceName = $dbObj->get_where('cce_list', array('class' => $class['standard']))->result_array();
            $cceNameArr[] = $cceName;
        }
        foreach ($cceNameArr as $mainKey => $mainVal) {
            $cceListArr = array();
            $i = 'A';
            foreach ($mainVal as $subKey => $subVal) {
                $subVal['cce_name'] = substr_replace($subVal['cce_name'], '', 12);
                $cceResult = $this->GetCcceGardeById($subVal['id'], $dataObj['adm_no'], $dbObj);
                if (empty($cceResult)) {
                    $cceResult['di'] = '-';
                    $cceResult['grade'] = '-';
                }
                if (!in_array($subVal['cce_name'], array_column($cceListArr, 'part'))) {
                    $cceListArr[] = array(
                        'part' => $subVal['cce_name'],
                        'title' => ($mainKey + 1) . '(' . $i . ') :' . $subVal['caption_show'],
                        'details' => array(
                            array(
                                'caption' => $subVal['caption_show'],
                                'di' => $cceResult['di'],
                                'grade' => $cceResult['grade'],
                                'cce_name' => $mainVal[$subKey]['cce_name']
                            )
                        )
                    );
                    $i++;
                } else {
                    $arrKey = array_search($subVal['cce_name'], array_column($cceListArr, 'part'));
                    $cceListArr[$arrKey]['details'][] = array(
                        'caption' => $subVal['caption_show'],
                        'di' => $cceResult['di'],
                        'grade' => $cceResult['grade'],
                        'cce_name' => $mainVal[$subKey]['cce_name']
                    );
                }
            }

            $sortArr[] = $cceListArr;
        }
        return $sortArr;
    }

    public function GetCcceGardeById($cceId, $adm_no, $dbObj) {
        $dbObj->select('a.di,b.grade');
        $dbObj->from('cce_grades_di as a');
        $dbObj->join('cce_grade_setting as b', 'a.grade=b.id');
        $dbObj->where('a.adm_no', $adm_no);
        $dbObj->where('a.cce_id', $cceId);
        $gardeResult = $dbObj->get()->row_array();
        return $gardeResult;
    }

    public function GetStudentReportCardPrimaryData($dataObj) {
        $dbObj = $this->load->database($this->GetStudentDatabaseName($dataObj['school_code']), TRUE);
        $studentBasicData = $this->GetStudentBasicInfo($dbObj, $dataObj);
        $stuSchoolData = $this->GetSchoolInfo($dbObj, $dataObj);
        $studentAttData = $this->GetStudentAttData($dbObj, $dataObj);
        $classteacher = $this->GetClassTeacher($dbObj, $dataObj);
        $marksGradeData = $this->GetMarksGradeData($dbObj);
//        $principleName = $this->GetPrincipal($dbObj, $dataObj);
        $final_arr = array('cls_tech_name' => $classteacher, 'marksGrade' => $marksGradeData, 'princi' => 'Mr.Anurag Mittal', 'schoolData' => $stuSchoolData, 'stuData' => $studentBasicData, 'attData' => $studentAttData);
        return $final_arr;
    }

    public function getSecndryReportCard($dataObj) {
        $dbObj = $this->load->database($this->GetStudentDatabaseName($dataObj['school_code']), TRUE);
        $studentBasicData = $this->GetStudentBasicInfo($dbObj, $dataObj);
        $stuSchoolData = $this->GetSchoolInfo($dbObj, $dataObj);
        $studentAttData = $this->GetStudentAttData($dbObj, $dataObj);
        $this->load->model('core/core', 'coreObj');
        $subjectList = $this->coreObj->GetStudentSubjectList($dataObj['adm_no'], $studentBasicData['standard'], $dbObj);
        $termData = $this->GetTermWiseReport($dataObj, $subjectList, $dbObj, 'secndry');
        $cceGarde = $this->GetCceGardeData($dataObj, $dbObj);
        $grades = array();

        for ($i = 0; $i < count($cceGarde); $i++) {
            for ($j = 0; $j < count($cceGarde[$i]); $j++) {
                for ($k = 0; $k < count($cceGarde[$i][$j]['details']); $k++) {
                    $grades[] = array('caption' => $cceGarde[$i][$j]['details'][$k]['caption'], 'grade' => $cceGarde[$i][$j]['details'][$k]['grade']);
                }
            }
        }
        $final_arr = array('stuData' => $studentBasicData, 'schoolData' => $stuSchoolData, 'attData' => $studentAttData, 'subjectlist' => $subjectList, 'term' => $termData, 'cce' => $grades);
//        $final_arr = array('cls_tech_name' => $classteacher, 'marksGrade' => $marksGradeData, 'princi' => 'Mr.Anurag Mittal', 'schoolData' => $stuSchoolData, 'stuData' => $studentBasicData, 'attData' => $studentAttData);
        return $final_arr;
    }

    public function GetStudentReportCardData($dataObj) {
        $dbObj = $this->load->database($this->GetStudentDatabaseName($dataObj['school_code']), TRUE);
        $this->load->model('core/core', 'coreObj');
        $standard = $this->studentclass->GetStudentStandard($this->GetStudentDatabaseName($dataObj['school_code']), $dataObj['adm_no']);
        $subjectList = $this->coreObj->GetStudentSubjectList($dataObj['adm_no'], $standard, $dbObj);
        $termData = $this->GetTermWiseReport($dataObj, $subjectList, $dbObj);
        $cceGarde = $this->GetCceGardeData($dataObj, $dbObj);
        $finalReportArr['part1'] = array('subjectList' => $subjectList, 'term' => $termData, 'cce' => $cceGarde[0]);
        $finalReportArr['part2'] = $cceGarde[1];
        $finalReportArr['part3'] = $cceGarde[2];
        return $finalReportArr;
    }

    public function GetMarksGradeData($dbObj) {
        $marksGrade = $dbObj->get_where('marks_grade_settings')->result_array();
        return $marksGrade;
    }

    public function GetStudentBasicInfo($dbObj, $dataObj) {
        $medicalDetails = $this->studentclass->GetStudentMedicalDeatil($this->GetStudentDatabaseName($dataObj['school_code']), $dataObj['adm_no']);
        $dbObj->select('a.*,c.standard,c.section');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as c', 'a.section_id=c.id');
        $dbObj->where('a.adm_no', $dataObj['adm_no']);
        $dbObj->where('a.section_id', $dataObj['section_id']);
        $studetail = $dbObj->get()->row_array();
        $guardianDetail = $this->getGuardianDetail($dbObj, $dataObj['adm_no']);
        if (!empty($guardianDetail)) {
            $studetail['father'] = $guardianDetail[0];
            $studetail['mother'] = $guardianDetail[1];
        }
        $studetail['medicalDetail'] = $medicalDetails;

        return $studetail;
    }

    public function getGuardianDetail($dbObj, $adm_no) {
        $relation = ['father', 'mother'];
        $dbObj->select('g_name,relation');
        $dbObj->where('adm_no', $adm_no);
        $dbObj->where_in('relation', $relation);
        $guardian = $dbObj->get("gaurdian_details")->result_array();
        if (!empty($guardian)) {
            return $guardian;
        } else {
            return array(array('g_name' => 'NA', 'relation' => 'father'), array('g_name' => 'NA', 'relation' => 'mother'));
        }
    }

    public function GetSchoolInfo($dbObj, $dataObj) {
        $dbObj->select('school_name,school_affiliation_no,school_board_name,school_address,school_phone,email_id');
        $dbObj->from('school_setting');
        $schooldetail = $dbObj->get()->row_array();
        $this->db->select('brand_logo_path');
        $this->db->where('school_code', $dataObj['school_code']);
        $school_logo_path = $this->db->get('school_list')->row_array();
        $schooldetail = array_merge($schooldetail, $school_logo_path);
        $session = $this->GetSchoolSession($dbObj);
        $schooldetail['school_session'] = $session;
        return $schooldetail;
    }

    public function GetStudentAttData($dbObj, $dataObj) {
        $term = array('TERM1', 'TERM2');
        $dbObj->select('date_from,date_to,item');
        $dbObj->where_in('item', $term);
        $term_dates = $dbObj->get("session_term_setting")->result_array();
        for ($i = 0; $i < count($term_dates); $i++) {
            $dbObj->select("count(id) as totattndnc");
            $term_totalcount = $dbObj->get_where('session_days', array('is_holiday' => 'No', 'date >=' => $term_dates[$i]['date_from'], 'date <=' => $term_dates[$i]['date_to']))->row_array();
            $dbObj->select("count(id) as studentattendnc");
            $term_att = $dbObj->get_where('attendance_detail', array('att_status' => 'PRESENT', 'adm_no' => $dataObj['adm_no'], 'attendance_date >=' => $term_dates[$i]['date_from'], 'attendance_date <=' => $term_dates[$i]['date_to']))->row_array();
            $final_att[$term_dates[$i]['item']] = array_merge($term_totalcount, $term_att);
        }
        return $final_att;
    }

    public function GetClassTeacher($dbObj, $dataObj) {
        $dbObj->select('standard,section,class_teacher_id');
        $class_tacher_id = $dbObj->get_where('section_list', array('id' => $dataObj['section_id']))->row_array();
        $dbObj->select('salutation,staff_fname,staff_lname');
        $class_tacher_name = $dbObj->get_where('staff_details', array('id' => $class_tacher_id['class_teacher_id']))->row_array();
        $classteacher = array_merge($class_tacher_id, $class_tacher_name);
        return $classteacher['salutation'] . " " . $classteacher['staff_fname'] . " " . $classteacher['staff_lname'];
    }

    public function GetStudentDatabaseName($schoolCode) {
        include(APPPATH . 'config/database' . EXT);
        $schoolDb = $this->db->get_where('school_db_year_wise', array("school_code" => $schoolCode, "current_db" => "YES"))->row_array();
        $dynamicDB = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
        return $dynamicDB;
    }

    public function GetSchoolSession($dbObj) {
        $terms = $dbObj->get('session_term_setting')->result_array();
        $schoolSession = date('Y', strtotime($terms[0]['date_from'])) . ' - ' . date('Y', strtotime($terms[1]['date_to']));
        return $schoolSession;
    }

//    public function GetPrincipal($dbObj, $dataObj) {
//        $sess_schoolcode = $this->session->userdata('school_code');
//        $dbObj->select('salutation,princi_fname,princi_lname');
//        $principal = $dbObj->get_where('',array('school_code'=>$sess_schoolcode))->row_array();
//        return $principal['salutation']." ".$principal['princi_fname']." ".$principal['princi_lname'];
//    }
}
