<?php

class attendance_model extends CI_Model {

    public function studentlist($dataObj, $staff_id, $staff_type, $section_id, $att_date) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        if (strtoupper($staff_type) == 'ADMIN') {
            $dbObj->select('firstname,lastname,adm_no,profile_pic_path');
            $result = $dbObj->get_where('biodata', array('section_id' => $section_id))->result_array();
            $this->load->model('staffapp/staffapp_core', 'coreObj');
            for ($i = 0; $i < count($result); $i++) {
                $std_name = $this->coreObj->GetStudentDetail($result[$i]['adm_no'], $dbObj);
                $studentlist[] = array('adm_no' => $result[$i]['adm_no'], 'std_name' => $std_name['student_name'], 'std_pic' => $std_name['student_pic']);
            }
            return $studentlist;
        } else {
            $dbObj->select('class_teacher_id');
            $class_tchr_id = $dbObj->get_where('section_list', array('id' => $section_id))->row_array();
            if ($staff_id == $class_tchr_id['class_teacher_id']) {
                $curr_date = date("Y-m-d");
                if ($curr_date == $att_date) {
                    $dbObj->select('firstname,lastname,adm_no,profile_pic_path');
                    $result = $dbObj->get_where('biodata', array('section_id' => $section_id))->result_array();
                    $this->load->model('staffapp/staffapp_core', 'coreObj');
                    for ($i = 0; $i < count($result); $i++) {
                        $std_name = $this->coreObj->GetStudentDetail($result[$i]['adm_no'], $dbObj);
                        $studentlist[] = array('adm_no' => $result[$i]['adm_no'], 'std_name' => $std_name['student_name'], 'std_pic' => $std_name['student_pic']);
                    }
                    return $studentlist;
                } else {
                    return array();
                }
            } else {
                return array();
            }
        }
    }

    public function absentlist($stu_list, $dataObj, $staff_id, $staff_type, $section_id, $att_date) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $abstudentlist = array();
        if (strtoupper($staff_type) == 'ADMIN') {
            $absent_std = $this->GetMySectionAbsentStudent($dbObj, $att_date, $section_id);
            if (!empty($absent_std)) {
                for ($i = 0; $i < count($absent_std); $i++) {
                    if (!empty($absent_std[$i])) {
                        $abtd_name = $this->coreObj->GetStudentDetail($absent_std[$i]['adm_no'], $dbObj);
                        $abstudentlist[] = array('abst_name' => $abtd_name['student_name'], 'attr_reason' => $absent_std[$i]['reason'], 'std_pic' => $abtd_name['student_pic']);
                    }
                }
            }
            return $abstudentlist;
        } else {
            $dbObj->select('class_teacher_id');
            $class_tchr_id = $dbObj->get_where('section_list', array('id' => $section_id))->row_array();
            if ($staff_id == $class_tchr_id['class_teacher_id']) {
                $curr_date = date("Y-m-d");
                if ($curr_date == $att_date) {
                    $absent_std = $this->GetMySectionAbsentStudent($dbObj, $att_date, $section_id);

                    if (!empty($absent_std)) {
                        for ($i = 0; $i < count($absent_std); $i++) {
                            $abtd_name = $this->coreObj->GetStudentDetail($absent_std[$i]['adm_no'], $dbObj);
                            $abstudentlist[] = array('abst_name' => $abtd_name['student_name'], 'attr_reason' => $absent_std[$i]['reason'], 'std_pic' => $std_name['student_pic']);
                        }
                    }

                    return $abstudentlist;
                } else {
                    return "Enter today's date";
                }
            } else {
                return "You are not the class teacher";
            }
        }
    }

    public function GetMySectionAbsentStudent($dbObj, $att_date, $section_id) {
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.profile_pic_path_thumbnail,b.reason');
        $dbObj->from('biodata a');
        $dbObj->join('attendance_detail b', 'a.adm_no = b.adm_no');
        $dbObj->where('b.attendance_date', $att_date);
        $dbObj->where('a.section_id', $section_id);
        $dbObj->where('b.att_status', 'ABSENT');
        $absent_std = $dbObj->get()->result_array();
//        echo $dbObj->last_query();exit;
        return $absent_std;
    }

    public function attndanceData($dataObj, $staff_id, $staff_type, $section_id, $att_date) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('staffapp/attendance_model', 'modelObj');
        $absent = 0;
        $total = 0;
        $att_date_formt = date('Y-m-d', strtotime($att_date));
        $isHoliday = $this->CheckHoliday($att_date_formt, $dbObj);
        if ($isHoliday) {
            return array('holiday' => 'School close on ' . date('jS M,Y', strtotime($att_date)));
        } else {
            $stu_list = $this->studentlist($dataObj, $staff_id, $staff_type, $section_id, $att_date_formt);
            $abs_stu_list = $this->absentlist($stu_list, $dataObj, $staff_id, $staff_type, $section_id, $att_date_formt);
            $header = $this->attndcheader($dataObj, $section_id);
            if (!empty($abs_stu_list)) {
                for ($j = 0; $j < count($abs_stu_list); $j++) {
                    $absent++;
                }
                $header['absnt'] = $absent . ' students are absent.';
            } else {
                $header['absnt'] = 'All sudents are present.';
            }
            for ($r = 0; $r < count($stu_list); $r++) {
                $total++;
            }
            $present = $total - $absent;
            $footer = array('total' => $total, 'present' => $present, 'absent' => $absent);
            $finalarr = array('studetlist' => $stu_list, 'absentlist' => $abs_stu_list, 'header' => $header, 'footer' => $footer);
            return $finalarr;
        }
    }

    public function GetstandardSection($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('upper(CONCAT(standard , ' . ' , section)) AS sectionname, id as section_id', FALSE);
        $dbObj->order_by('order', 'ASC');
        $dbObj->from('section_list');
        $dbObj->where('status', 1);
        $section = $dbObj->get()->result_array();
        return $section;
    }

    public function attndcheader($dataObj, $section_id) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('staffapp/attendance_model', 'modelObj');
        $dbObj->select('class_teacher_id,standard,section');
        $classtchr_id = $dbObj->get_where('section_list', array('id' => $section_id))->row_array();
        $finalarr['class'] = 'At ' . $classtchr_id['standard'] . $classtchr_id['section'];
        $finalarr['desig'] = '(Class Teacher)';
        $finalarr['staff'] = $this->coreObj->GetStaffName($classtchr_id['class_teacher_id'], $dbObj);
        return $finalarr;
    }

    /*     * ***********************************************************Admin dashboard function ************************************************ */

   public function GetAdminAttData($dataObj, $school_code) {
        $curr_date = date('Y-m-d');
        $final_arr = array();
        $staff = array();
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('staffapp/admindashboard_model', 'coreObj');
        $dbObj->select('section_id');
        $section_id = $dbObj->get_where('attendance_status', array('att_date' => $curr_date))->result_array();
        for ($i = 0; $i < count($section_id); $i++) {
            $dbObj->select('b.firstname,b.lastname,b.adm_no');
            $dbObj->from('attendance_detail as a');
            $dbObj->join('biodata as b', 'a.adm_no = b.adm_no');
            $dbObj->where('a.attendance_date', $curr_date);
            $dbObj->where('a.att_status', 'ABSENT');
            $dbObj->where('b.section_id', $section_id[$i]['section_id']);
            $stu_absnt = $dbObj->get()->result_array();
            if (!empty($stu_absnt)) {
                $stu_name = array();
                $class_name = $this->coreObj->GetStandardFromSection_id($dbObj, $section_id[$i]['section_id']);
                for ($j = 0; $j < count($stu_absnt); $j++) {
                    $dbObj->select('attendance_date');
                    $dbObj->order_by('attendance_date', 'desc');
                    $dbObj->limit(2);
                    $date = $dbObj->get_where('attendance_detail', array('adm_no' => $stu_absnt[$j]['adm_no'], 'att_status' => 'ABSENT'))->result_array();
                    $stu_pic = $std_name = $this->coreObj->GetStudentDetail($stu_absnt[$j]['adm_no'], $dbObj);
                    $stu_name[] = array('stu_name' => $stu_absnt[$j]['adm_no'] . '.' . $stu_absnt[$j]['firstname'] . ' ' . $stu_absnt[$j]['lastname'], 'stu_pic' => $stu_pic['student_pic'], 'date' => date('jS M,Y', strtotime($date[0]['attendance_date'])));
                }
                $final_arr[] = array('abst_name' => $stu_name, 'class_name' => $class_name, 'section_id' => $section_id[$i]['section_id']);
            }
        }
        $dbObj->select('staff_id');
        $staff_id = $dbObj->get_where('staff_attendance', array('status' => 'ABSENT', 'date' => $curr_date))->result_array();
        if (!empty($staff_id)) {
            for ($i = 0; $i < count($staff_id); $i++) {
                $dbObj->select('date');
                $dbObj->order_by('date', 'DESC');
                $date = $dbObj->get_where('staff_attendance', array('staff_id' => $staff_id[$i]['staff_id']))->row_array();
                if ($date['date'] == date('Y-m-d')) {
                    $prevDeatil = '';
                } else {
                    $prevDeatil = 'He was also absent on ' . date('jS M Y', strtotime($date['date']));
                }
                $staff_name = $this->coreObj->GetStaffName($staff_id[$i]['staff_id'], $dbObj);
                $staff[] = array('staff_name' => $staff_name['staff_name'] . ' '.'Absent Today', 'prev_abst_date' => $prevDeatil, 'staff_pic' => $staff_name['staff_pic']);
            }
        } else {
            $staff = $staff_id;
        }
        $att_fnal = array('staff' => $staff, 'stu' => $final_arr);
        return $att_fnal;
    }

    public function CheckHoliday($date, $dbObj) {
        $dbObj->select('is_holiday');
        $dbObj->from('session_days');
        $dbObj->where('date', $date);
        $arrHoliday = $dbObj->get()->result_array();
        if (!empty($arrHoliday)) {
            if ($arrHoliday[0]['is_holiday'] == 'Yes') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
