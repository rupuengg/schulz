<?php

class Attendence_model extends CI_Model {

    public function checkAttendanceStatus($section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $dbObj->from('attendance_status');
        $dbObj->where('section_id', $section_id);
        $dbObj->where('att_date', date("Y-m-d"));
        $checkResult = $dbObj->get()->row_array();
        if (count($checkResult) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function GetClassTeacher($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('profile_pic_path_thumbnail');
        $dbObj->from('staff_details');
        $dbObj->where('id', $id);
        $myTempCt = $dbObj->get()->result_array();
        return $myTempCt;
    }

    public function CheckHoliday($date) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
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

    public function GetAttendence($section_id, $result, $date) {
        if ($section_id > 0) {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $myFinalDetail = array();
            $resultHoliday = $this->CheckHoliday($date);
            $classAttStatus = $this->checkAttendanceStatus($section_id);
            if ($classAttStatus) {
                $attStatus = 'Marked';
            } else {
                $attStatus = 'Not Marked';
            }
            if ($resultHoliday == true) {
                return 'HOLIDAY';
            } else {
                foreach ($result as $value) {
                    $myTempResult = $dbObj->get_where('attendance_detail', array("adm_no" => $value['adm_no'], "attendance_date" => $date))->row_array();
                    if (isset($myTempResult['adm_no'])) {
                        $myFinalDetail[] = array("adm_no" => $value['adm_no'], "name" => $value['firstname'] . ' ' . $value['lastname'], "att_status" => $myTempResult['att_status'], "reason" => $myTempResult['reason']);
                    } else {
                        $myFinalDetail[] = array("adm_no" => $value['adm_no'], "name" => $value['firstname'] . ' ' . $value['lastname'], "att_status" => "PRESENT", "reason" => "");
                    }
                }
                $ctName = $this->GetClassTeacherName($section_id, $dbObj);
                return array('att' => $myFinalDetail, 'ctName' => $ctName, 'attStatus' => $attStatus);
//                return $myFinalDetail;
            }
        } else {
            return 'NOTCLASSTEACHER';
        }
    }

    public function SaveAttendenceDetail($myArr, $date, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $staff_id = $this->session->userdata('staff_id');
        $deo_staff_id = $this->session->userdata('deo_staff_id');
        $data = array();
        $data_status = array(
            'section_id' => $section_id,
            'att_date' => $date,
            'via' => 'portal',
            'deo_entry_by' => $this->session->userdata('deo_staff_id'),
            'entry_by' => $this->session->userdata('staff_id')
        );
        for ($i = 0; $i < count($myArr); $i++) {
            $data[$i]['adm_no'] = $myArr[$i]['adm_no'];
            $data[$i]['attendance_date'] = $date;
            $data[$i]['reason'] = isset($myArr[$i]['reason']) ? trim($myArr[$i]['reason']) : "";
            $data[$i]['att_status'] = $myArr[$i]['att_status'] != null ? trim($myArr[$i]['att_status']) : "PRESENT";
            $data[$i]['deo_entry_by'] = $this->session->userdata('deo_staff_id');
            $data[$i]['entry_by'] = $this->session->userdata('staff_id');
            $dbObj->delete('attendance_detail', array('adm_no' => $myArr[$i]['adm_no'], "attendance_date" => $date));
        }

        if (count($data) > 0) {
            $dbObj->insert_batch('attendance_detail', $data);
            $dbObj->delete('attendance_status', array('section_id' => $section_id, 'att_date' => $date));
            $dbObj->insert('attendance_status', $data_status);

            if ($dbObj->affected_rows() == 0) {
                return - 1;
            } else {
                return $dbObj->insert_id();
            }
        } else {
            return false;
        }
    }

    public function MarkAllAttendenceDetail($myArr, $date, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data_all = array();
        $data_status = array('section_id' => $section_id, 'att_date' => $date, 'via' => 'portal');

        for ($i = 0; $i < count($myArr); $i++) {
            $data_all[$i]['adm_no'] = $myArr[$i]['adm_no'];
            $data_all[$i]['attendance_date'] = $date;
            $data_all[$i]['reason'] = "";
            $data_all[$i]['att_status'] = "PRESENT";
            $data_all[$i]['deo_entry_by'] = $this->session->userdata('deo_staff_id');
            $data_all[$i]['entry_by'] = $this->session->userdata('staff_id');
            $dbObj->delete('attendance_detail', array('adm_no' => $myArr[$i]['adm_no'], "attendance_date" => $date));
        }
        if (count($data_all) > 0) {
            $result_section = $this->getAttStatus($section_id, $date);
            if ($result_section == 'MARKED') {
                return FALSE;
            } else {
                $dbObj->insert_batch('attendance_detail', $data_all);
                //$dbObj->delete('attendance_status', array('section_id' => $section_id));
                $dbObj->insert('attendance_status', $data_status);
                if ($dbObj->affected_rows() == 0) {
                    return - 1;
                } else {
                    return $dbObj->insert_id();
                }
            }
        } else {
            return false;
        }
    }

    //summary model

    public function getAttStatus($section_id, $date) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(id) as idd');
        $dbObj->from('attendance_status');
        $dbObj->where('section_id', $section_id);
        $dbObj->where('att_date', $date);
        $myTempResult = $dbObj->get()->result_array();
        if (($myTempResult[0]['idd']) == 0) {
            $final = "UNMARKED";
        } else {
            $final = "MARKED";
        }
        return $final;
    }

    public function getClassTeacherSum($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,staff_fname,staff_lname');
        $dbObj->from('staff_details a');
        $dbObj->join('section_list b', 'a.id=b.class_teacher_id');
        $dbObj->where('b.id', $id);
        $myTempCt = $dbObj->get()->result_array();
        return $myTempCt;
    }

    public function GetSummary($result2, $date) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $finalMarked = array();
        $finalUnmarked = array();

        foreach ($result2 as $val) {
            $result_section = $this->getAttStatus($val['id'], $date);
            $val['status'] = $result_section;
//            $val['status'] = 'MARKED';
            $resultClassTeacher = $this->getClassTeacherSum($val['id']);
            if (isset($resultClassTeacher)) {
                $val['teacher'] = $resultClassTeacher;
            } else {
                $val['teacher'] = "";
            }
            if ($result_section == "MARKED") {   //open after summer vaction.. 
                $finalMarked[] = $val;
            } else {
                $finalUnmarked[] = $val;
            }
        }

        $i = 0;
        foreach ($finalMarked as $value) {
            $dbObj->select('a.adm_no,a.firstname,a.lastname,a.profile_pic_path_thumbnail,b.reason');
            $dbObj->from('biodata a');
            $dbObj->join('attendance_detail b', 'a.adm_no = b.adm_no');
            $dbObj->where('b.attendance_date', $date);
            $dbObj->where('a.section_id', $value['id']);
            $dbObj->where('b.att_status', 'ABSENT');
            $query = $dbObj->get()->result_array();
            $dbObj->select('count(adm_no) as totalstudent');
            $dbObj->from('biodata');
            $dbObj->where('section_id', $value['id']);
            $total = $dbObj->get()->result_array();
            $finalMarked[$i]['total'] = $total[0]['totalstudent'];
            $finalMarked[$i]['student'] = $query;
            $i++;
        }

        $finalResult = array_merge($finalMarked, $finalUnmarked);
//        echo '<pre>';
//        print_r($finalResult);exit;
        return $finalResult;
    }

    public function GetClassTeacherName($sectionId, $dbObj) {
        $dbObj->select('class_teacher_id,section,standard');
        $classTeacherId = $dbObj->get_where('section_list', array('id' => $sectionId, 'status' => 1))->row_array();
        $dbObj->select('id,staff_fname,staff_lname');
        $ctName = $dbObj->get_where('staff_details', array('id' => $classTeacherId['class_teacher_id']))->row_array();
        $ctName['section'] = $classTeacherId['section'];
        $ctName['standard'] = $classTeacherId['standard'];
        return $ctName;
    }

    /****************************************************Late attendence module**************************************************************** */

    public function studentname($studentname) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('firstname,lastname,adm_no');
        $dbObj->like('firstname', $studentname);
        $dbObj->or_like('adm_no', $studentname);
        $dbObj->where('section_id !=',-1);
        $result = $dbObj->get('biodata')->result_array();
        return $result;
    }

    public function savelatedata($latedata) {
        if (!empty($latedata)) {
            for ($i = 0; $i < count($latedata); $i++) {
                $insertArr[] = array('adm_no' => $latedata[$i]['adm_no'], 'coming_date' => $latedata[$i]['coming_date'], 'coming_time' => $latedata[$i]['coming_time'], 'reason' => $latedata[$i]['reason'], 'entry_by' => $latedata[$i]['entry_by'], 'deo_entry_by' => $latedata[$i]['deo_entry_by']);
                if ($latedata[$i]['reason'] == '' || $latedata[$i]['coming_date'] == '' || $latedata[$i]['adm_no'] == 'undefined') {
                    return -1;
                }
            }
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->insert_batch('late_coming_details', $insertArr);
            return $dbObj->insert_id();
        } else {
            return -1;
        }
    }

}
