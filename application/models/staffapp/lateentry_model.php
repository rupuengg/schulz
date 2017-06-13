<?php

class lateentry_model extends CI_Model {

    public function MainLateData($dataObj) {
        $curr_date = date('Y-m-d');
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $graph = $this->GraphData($dbObj);
        $stulatedata = $this->StuLateData($dbObj, $curr_date);
        $stafflatedata = $this->StaffLateData();
        return array('graphData' => $graph, 'studentLateData' => $stulatedata, 'staffLateData' => $stafflatedata);
    }

    public function GraphData($dbObj) {
        $current_date = date('Y-m-d');
        $dbObj->select('date as log_date');
        $dbObj->order_by('log_date', 'DESC');
        $dbObj->limit(6);
        $date = $dbObj->get_where('session_days', array('date <=' => $current_date, 'is_holiday' => 'No'))->result_array();
        $date = array_reverse($date);
        for ($i = 0; $i < count($date); $i++) {
            $date_r = date('d-M', strtotime($date[$i]['log_date']));
            $stud_count = $this->GetStudLateCount($dbObj, $date[$i]['log_date']);
            $final_arr[] = array('day' => $date_r, 'staff' => 0, 'stud' => $stud_count);
        }
        return $final_arr;
    }

    public function GetStudLateCount($dbObj, $date) {
        $dbObj->select('count(id) as stud_count');
        $count = $dbObj->get_where('late_coming_details', array('coming_date' => $date))->result_array();
        return $count[0]['stud_count'];
    }

    public function StuLateData($dbObj, $date) {
        $dbObj->select('adm_no,coming_time');
        $stu_late = $dbObj->get_where('late_coming_details', array('coming_date' => $date))->result_array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        if (!empty($stu_late)) {
            $dbObj->select('school_open_time');
            $comin_time = $dbObj->get('school_setting')->row_array();
            $coming_time_fnl = strtotime(date('Y-m-d') . " " . $comin_time['school_open_time']);
            for ($i = 0; $i < count($stu_late); $i++) {
                $stu_detail = $this->coreObj->GetStudentDetail($stu_late[$i]['adm_no'], $dbObj);
                $stu_late_fnl = strtotime(date('Y-m-d') . " " . $stu_late[$i]['coming_time']);
                $diff = ($stu_late_fnl - $coming_time_fnl);
                $late_min = abs($diff / 60);
                $fnal_arr[] = array('stu_name' => $stu_detail['student_name'] . '(' . $stu_detail['class'] . ')', 'late_by' => 'Late by ' . round($late_min) . ' minutes', 'stu_pic' => $stu_detail['student_pic']);
            }
          
        } else {
            return array();
        }
    }

    public function StaffLateData() {
        $data = array(array("staff_name" => 'K.C. Thomas', 'late_by' => 'Late by 30 minutes',
                "staff_pic" => base_url().'index.php/app/getstaffphoto/1/THUMB'),
            array("staff_name" => 'Anuj Singh', 'late_by' => 'Late by 5 minutes',
                "staff_pic" => base_url().'index.php/app/getstaffphoto/4/THUMB'));
        return $data;
    }

}
