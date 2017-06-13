<?php

class ccegrades_model extends CI_Controller {

    public function GetCCENameList($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('b.cce_name,b.id as cce_id,c.standard,c.section,c.id as section_id');
        $dbObj->from('cce_staff_relation as a');
        $dbObj->join('cce_list as b', 'b.id=a.cce_id', 'left');
        $dbObj->join('section_list as c', 'c.id=a.section_id', 'left');
        $dbObj->where('c.status', '1');
        $dbObj->where('a.staff_id', $dataObj['id']);
        $dbObj->order_by('c.order');
        $output = $dbObj->get()->result_array();
        for ($i = 0; $i < count($output); $i++) {
            $result[] = array('class' => $output[$i]['standard'] . $output[$i]['section'] . "-" . $output[$i]['cce_name'], 'cce_id' => $output[$i]['cce_id'], 'section_id' => $output[$i]['section_id']);
        }
        return $result;
    }

    public function GetStudentccegradeData($dataObj, $term, $section_id, $cceid) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $total = 0;
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $activeClass = $this->coreObj->getActiceClassStatus($dbObj, $section_id);
        if ($activeClass) {
            $dbObj->select('adm_no, adm_no_display, firstname, lastname, sex, dob_date, ad_date, address1, city, state, pin_code,profile_pic_path_thumbnail, section_id, roll_no');
            $resultStudent = $dbObj->get_where('biodata', array('section_id' => $section_id))->result_array();
            for ($i = 0; $i < count($resultStudent); $i++) {
                $total++;
                $studentpers_data = $this->coreObj->GetStudentDetail($resultStudent[$i]['adm_no'], $dbObj);
                $dbObj->select('di,grade,timestamp');
                $dbObj->where('term', $term);
                $dbObj->where('adm_no', $resultStudent[$i]['adm_no']);
                $dbObj->where('cce_id', $cceid);
                $result = $dbObj->get('cce_grades_di')->result_array();
                $resultStudentcce[$i]['stu_name'] = $studentpers_data['student_name'];
                $resultStudentcce[$i]['stu_pic'] = $studentpers_data['student_pic'];
                if (count($result) > 0) {
                    for ($j = 0; $j < count($result); $j++) {
                        $stu_grades = $this->GetAllCceGrade($result[$j]['grade'], $dbObj);
                        $resultStudentcce[$i]['date'] = date("jS M,Y", strtotime($result[$j]['timestamp']));
                        $resultStudentcce[$i]['di'] = $result[$j]['di'];
                        $resultStudentcce[$i]['grade'] = $stu_grades['grade'];
                    }
                } else {
                    $resultStudentcce[$i]['date'] = '';
                    $resultStudentcce[$i]['grade'] = 0;
                    $resultStudentcce[$i]['di'] = '';
                }
            }
            $header = $this->headergrades($dbObj, $section_id);
            $header['clss_stats'] = 'Grades of total ' . $total . ' Students are loaded';
            $fnal = array('grade' => $resultStudentcce, 'header' => $header);
            return $fnal;
        } else {
            return -1;
        }
    }

    public function headergrades($dbObj, $section_id) {
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        $dbObj->select('class_teacher_id,standard,section');
        $clsstchr_id = $dbObj->get_where('section_list', array('id' => $section_id))->row_array();
        $clsstchr = $this->coreObj->GetStaffName($clsstchr_id['class_teacher_id'], $dbObj);
        $result = array('class' =>$clsstchr_id['standard'] . $clsstchr_id['section'], 'staff_name' => $clsstchr['staff_name'], 'staff_pic' => $clsstchr['staff_pic'], 'desig' => '(Class Teacher)');
        return $result;
    }

    public function GetAllCceGrade($gradeid, $dbObj) {
        $dbObj->distinct();
        $dbObj->select('grade');
        $result = $dbObj->get_where('cce_grade_setting', array('id' => $gradeid))->row_array();
        return $result;
    }

}
