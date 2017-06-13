<?php

class timetable_controller extends MY_Controller {

    public function ManagePeriod() {
        $this->load->view('staff/time_table/manage_period.php');
    }

    public function ClassWiseTimeTable($result = '-1') {
        $this->load->view('staff/time_table/classwise_timetable.php', array('classdata' => $result));
    }

    public function GetGroupList() {
        $this->load->model('staff/timetable_model', 'ModelObj');
        $result = $this->ModelObj->getAllClassGroup();
        try {
            echo json_encode($result);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getSection() {
        $group_id = $this->uri->segment(3);
        $this->load->model('staff/timetable_model', 'ModelObj');
        $sectionList = $this->ModelObj->getSection($group_id);
        echo json_encode($sectionList);
    }

    public function GetPeriodlist() {
        $group_id = $this->uri->segment(3);
        $this->load->model('staff/timetable_model', 'ModelObj');
        $result = $this->ModelObj->getAllPeriod($group_id);
        echo json_encode($result);
    }

    public function GetSubjectList() {
        $section_id = $this->uri->segment(3);
        $this->load->model('staff/timetable_model', 'modelObj');
        $subjectList = $this->modelObj->GetClassSubjectList($section_id);

        echo json_encode($subjectList);
    }

    public function GetClassTimeTable() {
        $group_id = $this->uri->segment(3);
        $section_id = $this->uri->segment(4);
        $this->load->model('staff/timetable_model', 'modelObj');
        $result = $this->modelObj->GetClassTimeTable($group_id, $section_id);
        $this->ClassWiseTimeTable($result);
    }

    public function saveperioddetail() {
        $data = json_decode($this->input->post('data'), true);
        $data['group_id'] = $this->uri->segment(3);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $gruopdata = $dbObj->get_where('ttm_period_details', array('group_id' => $data['group_id'], 'period_name' => $data['period_name']))->result_array();
        if (count($gruopdata) > 0) {
            echo '{"status":"FALSE","message":"Period Name is already exists"}';
        } else {
            $this->load->model('staff/timetable_model', 'modelObj');
            $id = $this->modelObj->SavePeriod($data);
            if ($id) {
                echo '{"status":"TRUE","message":"Saved successfully","objId":' . $id . '}';
            } else {
                echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
            }
        }
    }

    public function DeletePeriodDetail() {
        $id = json_decode($this->input->post('data'), true);
        $this->load->model('staff/timetable_model', 'modelObj');
        $delid = $this->modelObj->DeletePeriod($id);
        if ($delid) {
            echo '{"status":"TRUE","message":"Deleted successfully","objId":' . $id . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    public function AssignSubjectTeacher() {
        $data = json_decode($this->input->post('data'), true);
        $this->load->model('staff/timetable_model', 'modelObj');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $subjectdata = $dbObj->get_where('ttm_class_timetable', array('period_id' => $data['period_id'], 'section_id' => $data['section_id'], 'week_day_name' => $data['week_day_name']))->row_array();
        if (count($subjectdata) > 0) {
            $result = $this->modelObj->UpdateSubjectTeacher($data, $subjectdata['id']);
            if ($result) {
                echo '{"status":"TRUE","message":"Updated successfully","objId":' . $result . '}';
            } else {
                echo '{"status":"FALSE","message":"Oops! You have assigned same subject.Please change the subject and try again."}';
            }
        } else {
            $id = $this->modelObj->SaveSubjectTeacher($data);
            if ($id) {
                echo '{"status":"TRUE","message":"Saved successfully","objId":' . $id . '}';
            } else {
                echo '{"status":"FALSE","message":"Oops! This teacher allready busy in other class, Please assign another peroid."}';
            }
        }
    }

    /*     * ********************************************Group wise timetable******************************************* */

    public function GetStaffPeriod() {
        $staffId = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/timetable_model', 'modelObj');
        $subjectdata = $this->modelObj->LoadTeacherSubject($staff_id);
        $teacherList = $this->modelObj->GetAllTeacherFromGroupId($staffId);
        echo json_encode(array('periodDetail' => $subjectdata['periodDetail'], 'substitutedata' => $subjectdata['substitutedata'], 'teacherList' => $teacherList));
    }

    public function GroupWiseSettings($staff_id = -1) {
        $this->load->view('staff/time_table/groupwise_view');
    }

    public function SaveGroups() {
        $groupdata = json_decode($this->input->post('data'), true);
        $this->load->model('staff/timetable_model', 'modelObj');
        $id = $this->modelObj->AddGroupName($groupdata['group_name']);
        $data['group_name'] = $groupdata['group_name'];
        foreach ($groupdata['group_classes'] as $res) {
            $class = $this->modelObj->SaveClasses($res, $id);
        }
        if ($class) {
            echo '{"status":"TRUE","message":"Saved successfully","objId":' . $class . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    public function AddGroupStaffs() {
        $groupId = json_decode($this->input->post('data'));
        $this->load->model('staff/timetable_model', 'modelObj');
        $class = $this->modelObj->AddGroupStaff($groupId);
        echo json_encode($class);
    }

    public function AssignTeachers() {
        $this->load->model('staff/timetable_model', 'modelObj');
        $assignteachers = $this->modelObj->AssignTeacher();
        echo json_encode($assignteachers);
    }

    public function SaveAssignTeachers() {
        $assignteacher = json_decode($this->input->post('data'), true);
        $this->load->model('staff/timetable_model', 'modelObj');
        foreach ($assignteacher['staff_id'] as $res) {
            $groupteachers = $this->modelObj->SaveAssignTeacher($res, $assignteacher['group_id']);
        }
        if ($groupteachers) {
            echo '{"status":"TRUE","message":"Saved successfully","objId":' . $groupteachers . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    public function GetGroupDetails() {
        $this->load->model('staff/timetable_model', 'modelObj');
        $viewgroups = $this->modelObj->GetGroupDetail();
        echo json_encode($viewgroups);
    }

    public function DeleteGroups() {
        $groupid = json_decode($this->input->post('data'), true);
        $this->load->model('staff/timetable_model', 'modelObj');
        $deleteid = $this->modelObj->DeleteGroups($groupid);
        if ($deleteid) {
            echo '{"status":"TRUE","message":"Deleted successfully","objId":' . $deleteid . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    /*     * **********************************Working Hours Setting ****************************** */

    public function WorkingHours() {
        $this->load->view('staff/time_table/calculate_working_hours.php');
    }

    public function GetWorkingHours() {
        $this->load->model('staff/timetable_model', 'modelObj');
        $workinghours = $this->modelObj->GetWorkingHour();
        echo json_encode($workinghours);
    }

    public function SaveWorkingHours() {
        $workhours = json_decode($this->input->post('data'), true);
        $this->load->model('staff/timetable_model', 'modelObj');
        $workdetails = $this->modelObj->SaveWorkingHour($workhours);
        if ($workdetails != -1) {
            echo printCustomMsg("TRUE", "Working hours Setting Saved..", $workdetails);
        } else {
            echo printCustomMsg("SAVEERR", "Some error occurred, Please try again.", $workdetails);
        }
    }

    /*     * **********************************Substitute Time Table***************************************** */

    public function SubstituteTimeTable($substitute_date = null) {
        if ($substitute_date == null) {
            $substitute_date = date('Y-m-d');
        }
        $this->load->view('staff/time_table/substitute_timetable.php', array("substitute_date" => $substitute_date));
    }

    public function LoadAbsentTeachers() {
        $groupId = json_decode($this->input->post('data'));
        $this->load->model('staff/timetable_model', 'modelObj');
        $absentadata = $this->modelObj->LoadAbsentTeacher($groupId);
        echo json_encode($absentadata);
    }

    public function GetSubstituteTeachers() {
        $this->load->model('staff/timetable_model', 'modelObj');
        $substitutedata = $this->modelObj->GetSubstituteTeacher($staff_id);
        echo json_encode($substitutedata);
    }

    public function LoadTeacherSubjects() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/timetable_model', 'modelObj');
        $subjectdata = $this->modelObj->LoadTeacherSubject($dataObj);
        echo json_encode($subjectdata);
    }

    public function SaveSubstituteDetails() {
        $substitute = json_decode($this->input->post('data'), true);
        $this->load->model('staff/timetable_model', 'modelObj');
        $getsubstitute = $this->modelObj->GetSubstituteData($substitute);
        if ($getsubstitute > 0) {
            $substitutedata = $this->modelObj->UpdateSubstituteDetail($substitute, $getsubstitute['id']);
            if ($substitutedata > 0) {
                echo printCustomMsg("TRUE", "Substitute teacher updated successfully..");
            } else {
                echo printCustomMsg("SAVEERR", "This teacher is already substituted.Please assign a different teacher.", $substitutedata);
            }
        } else {
            $substitutedata = $this->modelObj->SaveSubstituteDetail($substitute);
            if ($substitutedata != -1) {
                echo printCustomMsg("TRUE", "Substitute teacher assigned successfully..", $substitutedata);
            } else {
                echo printCustomMsg("SAVEERR", "Some error occurred, Please try again.", $substitutedata);
            }
        }
    }

}

?>