<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class timetable_model extends CI_Model {

    public function getAllClassGroup() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $allClassGroup = $dbObj->get('ttm_group_details')->result_array();
        return $allClassGroup;
    }

    public function getSection($group_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id as section_id,a.standard,a.section,a.order,b.class_name');
        $dbObj->from('section_list as a');
        $dbObj->join('ttm_group_class_relation as b', 'a.standard=b.class_name');
        $dbObj->order_by('a.order');
        $dbObj->where('a.status', 1);
        $dbObj->where('b.group_id', $group_id);
        $objstddata = $dbObj->get()->result_array();
        return $objstddata;
    }

    public function getAllPeriod($group_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $allPeriod = $dbObj->get_where('ttm_period_details', array('group_id' => $group_id))->result_array();
        return $allPeriod;
    }

    public function GetClassTimeTable($group_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,period_name,start_time,end_time,period_type');
        $dbObj->from('ttm_period_details');
        $dbObj->where('group_id', $group_id);
        $allPeriod = $dbObj->get()->result_array();
        $count = count($allPeriod);
        $finalArray = array('periodDetail' => $allPeriod, 'weekData' => $this->GetWekklyDetail($section_id, $count, $allPeriod));
        return $finalArray;
    }

    public function GetWekklyDetail($section_id, $count, $myPeriodData) {
        $m = 0;
        $weeklist = array('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');
        $dayName = array('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATARDAY');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        for ($i = 0; $i < count($weeklist); $i++) {
            $k = 0;
            for ($j = 0; $j < count($myPeriodData); $j++) {
                $dbObj->select('a.period_id,a.section_id,b.id as staff_id,b.salutation,b.staff_fname,b.staff_lname,c.id as subject_id,c.subject_name,c.subject_short_name,c.cbse_cce_subject_name');
                $dbObj->from('ttm_class_timetable as a');
                $dbObj->join('staff_details as b', 'a.teacher_id=b.id');
                $dbObj->join('subject_list as c', 'a.subject_id=c.id');
                $dbObj->where('a.week_day_name', $weeklist[$i]);
                $dbObj->where('a.period_id', $myPeriodData[$j]['id']);
                $dbObj->where('a.section_id', $section_id);
                $dbObj->order_by('a.period_id', 'ASC');
                $query = $dbObj->get()->row_array();
                if (!empty($query)) {
                    $periodData[$k] = $query;
                    $k++;
                } else {
                    $periodData[$k] = array("period_id" => $myPeriodData[$j]['id'], "section_id" => $section_id, "staff_id" => '', "salutation" => '', "staff_fname" => '', "staff_lname" => '', "subject_id" => '', "subject_short_name" => '', "cbse_cce_subject_name" => '');
                    $k++;
                }
            }
            $myTemp[$m] = array('weekName' => $weeklist[$i], 'dayfullname' => $dayName[$i], 'holidayStatus' => FALSE, 'periodData' => $periodData);
            $m++;
        }
        return $myTemp;
    }

    public function GetClassSubjectList($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('b.id as subject_id,b.subject_name,b.subject_short_name,c.id as teacher_id,c.salutation,c.staff_fname,c.staff_lname');
        $dbObj->from('subject_staff_relation as a');
        $dbObj->join('subject_list as b', 'a.subject_id=b.id');
        $dbObj->join('staff_details as c', 'a.staff_id=c.id');
        $dbObj->where('a.section_id', $class);
        $query = $dbObj->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function GetClassSubjectTeacher() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('');
        $dbObj->from('subject_staff_relation as a');
        $dbObj->join('section_list as b', 'a.class_name=b.standard');
        $dbObj->where('b.id', $class);
        $query = $dbObj->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function SavePeriod($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data['entry_by'] = $this->session->userdata('staff_id');
        $data['deo_entry_by'] = $this->session->userdata('deo_staff_id');
        $dbObj->insert('ttm_period_details', $data);
        if ($dbObj->affected_rows() > 0) {
            return $dbObj->insert_id();
        } else {
            return false;
        }
    }

    public function DeletePeriod($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('ttm_period_details', array('id' => $id));
        return TRUE;
    }

    public function SaveSubjectTeacher($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $verifyData = $dbObj->get_where('ttm_class_timetable', array('period_id' => $data['period_id'], 'week_day_name' => $data['week_day_name'], 'teacher_id' => $data['teacher_id']))->row_array();
        if (!empty($verifyData)) {
            return false;
        } else {
            $data['entry_by'] = $this->session->userdata('staff_id');
            $data['deo_entry_by'] = $this->session->userdata('deo_staff_id');
            $dbObj->insert('ttm_class_timetable', $data);
            if ($dbObj->affected_rows() > 0) {
                return $dbObj->insert_id();
            } else {
                return false;
            }
        }
    }

    public function UpdateSubjectTeacher($data, $id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $id);
        $dbObj->update('ttm_class_timetable', $data);
        if ($dbObj->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*     * *******************************************************Group wise timetable module**************************************** */

    public function GetGroup($groupdata) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array("group_name" => $groupdata['group_name'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
        $quantity = $dbObj->insert('ttm_group_details', $data);
        $lastinsert_id = $dbObj->insert_id();
        if ($lastinsert_id > 0) {
            return $lastinsert_id;
        } else {
            return -1;
        }
    }

    public function AddGroupName($groupdata) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array("group_name" => $groupdata, "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
        $group = $dbObj->insert('ttm_group_details', $data);
        $lastinsert_id = $dbObj->insert_id();
        if ($lastinsert_id > 0) {
            return $lastinsert_id;
        } else {
            return -1;
        }
    }

    public function SaveClasses($class, $id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data['entry_by'] = $this->session->userdata('staff_id');
        $data['deo_entry_by'] = $this->session->userdata('deo_staff_id');
        $data['class_name'] = $class;
        $data['group_id'] = $id;
        $dbObj->insert('ttm_group_class_relation', $data);
        if ($dbObj->affected_rows() > 0) {
            return $dbObj->insert_id();
        } else {
            return false;
        }
    }

    public function AddGroupStaff($groupId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $groupCalssList = $dbObj->get_where('ttm_group_class_relation', array('group_id' => $groupId))->result_array();
//        echo $dbObj->last_query();exit;
        foreach ($groupCalssList as $row) {
            $dbObj->select('id');
            $result = $dbObj->get_where('section_list', array('standard' => $row['class_name']))->result_array();
            foreach ($result as $val) {
                $sectionListArry[] = $val['id'];
            }
        }
      //  print_r()
        $staffListArray = array();
        foreach ($sectionListArry as $row) {
            $dbObj->group_by('section_id');
            $groupTeacherList = $dbObj->get_where('subject_staff_relation', array('section_id' => $row))->result_array();
            if (!empty($groupTeacherList)) {
                foreach ($groupTeacherList as $res) {
                    $result = $dbObj->get_where('staff_details', array('id' => $res['staff_id']))->row_array();
                    if (!empty($result)) {
                        if (!in_array($result['id'], array_column($staffListArray, "id"))) {
                            $staffListArray[] = array('name' => $result['staff_fname'] . ' ' . $result['staff_lname'], 'id' => $result['id']);
                        }
                    }
                }
            }
        }
        if (!empty($staffListArray)) {
            return $staffListArray;
        } else {
            return false;
        }
    }

    public function AssignTeacher() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,salutation,staff_fname,staff_lname');
        $dbObj->from('staff_details');
        $dbObj->where('staff_type', 'faculty');
        $query = $dbObj->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function SaveAssignTeacher($staff_id, $group_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array("group_id" => $group_id, "staff_id" => $staff_id, "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
        $result = $dbObj->insert('ttm_group_staff_relation', $data);
        $lastinsert_id = $dbObj->insert_id();
        if ($lastinsert_id > 0) {
            return $lastinsert_id;
        } else {
            return -1;
        }
    }

    public function GetGroupDetail() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $groupdata = $dbObj->get('ttm_group_details')->result_array();
        foreach ($groupdata as $res) {
            $dbObj->select("class_name");
            $dbObj->from('ttm_group_class_relation');
            $dbObj->where('group_id', $res['id']);
            $groupresult = $dbObj->get()->result_array();
            $myarr = array();
            for ($i = 0; $i < count($groupresult); $i++) {
                $myarr[$i] = $groupresult[$i]['class_name'];
            }

            $groupArray[] = array("groupId" => $res['id'], "groupname" => $res['group_name'], "detail" => implode(',', $myarr));
        }
        return $groupArray;
    }

    public function DeleteGroups($groupid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('ttm_group_details', array('id' => $groupid));
        $dbObj->delete('ttm_group_class_relation', array('group_id' => $groupid));
        return true;
    }

    /*     * **********************************Working Hours Setting ****************************** */

    public function GetWorkingHour() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('working_days,working_hours');
        $dbObj->from('ttm_working_hours');
        $workinghoursdata = $dbObj->get()->row_array();
        if (!empty($workinghoursdata)) {
            return $workinghoursdata;
        } else {
            return -1;
        }
    }

    public function SaveWorkingHour($workhours) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->truncate('ttm_working_hours');
        $data = array("working_days" => $workhours['working_days'], "working_hours" => $workhours['working_hours'], "entry_by" => $this->session->userdata('staff_id'), "deo_entry_by" => $this->session->userdata('deo_staff_id'));
        $result = $dbObj->insert('ttm_working_hours', $data);
        $lastinsert_id = $dbObj->insert_id();
        if ($lastinsert_id > 0) {
            return $lastinsert_id;
        } else {
            return -1;
        }
    }

    /*     * **********************************Substitute Time Table***************************************** */

    public function LoadAbsentTeacher() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,salutation,staff_fname,staff_lname');
        $dbObj->from('staff_details');
        $dbObj->where('staff_type', 'faculty');
        $query = $dbObj->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function LoadTeacherSubject($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $dbObj->from('ttm_class_timetable as a');
        $dbObj->join('staff_details as b', 'a.teacher_id=b.id');
        $dbObj->join('subject_list as c', 'a.subject_id=c.id');
        $dbObj->join('section_list as d', 'a.section_id=d.id');
        $dbObj->where('a.teacher_id', $dataObj['staff_id']);
        $dbObj->where('a.week_day_name', strtoupper(date('D', strtotime($dataObj['arrange_date']))));
        $substitute = $dbObj->get()->result_array();
        $finalArray = array("substitutedata" => $substitute, "periodDetail" => $this->GetPeriodDetail($dataObj), 'staffList' => $this->GetSubstituteTeacher($dataObj['staff_id']));
        return $finalArray;
    }

    public function GetSubstituteTeacher($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $groupid = $dbObj->get_where('ttm_group_staff_relation', array('staff_id' => $staff_id))->row_array();
        if (!empty($groupid)) {
            $staffList = $this->AddGroupStaff($groupid['group_id']);
        } else {
            echo 'staff not assign yet of any group';
            exit;
        }

        return $staffList;
    }

    public function GetPeriodDetail($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.section_id,b.id,b.period_name,b.start_time,b.end_time,b.period_type');
        $dbObj->from('ttm_class_timetable as a');
        $dbObj->join('ttm_period_details as b', 'a.period_id=b.id');
        $dbObj->where('a.teacher_id', $dataObj['staff_id']);
        $dbObj->where('a.week_day_name', strtoupper(date('D', strtotime($dataObj['arrange_date']))));
        $perioddetail = $dbObj->get()->result_array();
        if (!empty($perioddetail)) {
            return $perioddetail;
        } else {
            return -1;
        }
    }

    public function SaveSubstituteDetail($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data['entry_by'] = $this->session->userdata('staff_id');
        $data['deo_entry_by'] = $this->session->userdata('deo_staff_id');
        $dbObj->insert('ttm_substitute_timetable', $data);
        if ($dbObj->affected_rows() > 0) {
            return $dbObj->insert_id();
        } else {
            return false;
        }
    }

    public function GetSubstituteData($data) {
//        print_r($data);exit;
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $dbObj->from('ttm_substitute_timetable');
        $dbObj->where('teacher_id', $data['teacher_id']);
        $dbObj->where('section_id', $data['section_id']);
        $dbObj->where('subject_id', $data['subject_id']);
        $dbObj->where('period_id', $data['period_id']);
        $dbObj->where('week_day_name', $data['week_day_name']);
        $result = $dbObj->get()->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return -1;
        }
    }

    public function UpdateSubstituteDetail() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $id);
        $result = $dbObj->update('ttm_substitute_timetable', $data);
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function GetAllTeacherFromGroupId($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('core/core', 'coreObj');
        $groupId = $dbObj->get_where('ttm_group_staff_relation', array('staff_id' => $staff_id))->row_array();
        $teacherList = $dbObj->get_where('ttm_group_staff_relation', array('group_id' => $groupId['group_id']))->result_array();
        foreach ($teacherList as $row) {
            if ($row['staff_id'] != $staff_id) {
                $staffDetail[] = $this->coreObj->GetStaffName($row['staff_id']);
            }
        }
        return $staffDetail;
    }

}
